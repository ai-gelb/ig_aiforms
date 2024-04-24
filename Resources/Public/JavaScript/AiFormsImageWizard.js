import { fetchOpenAICompletion } from "@igelb/ig-aiforms/FetchAi.js";
import Icons from "@typo3/backend/icons.js";

function AiFormsImage() {
  const clickButtons = document.querySelectorAll(".igjs-form-ai");
  const iconOn = "actions-infinity";
  const iconOff = "spinner-circle";

  clickButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      button.disabled = true;
      Icons.getIcon( iconOff , Icons.sizes.small).then((icon) => {
        button.replaceChild(document.createRange().createContextualFragment(icon), button.querySelector(".t3js-icon"));
      });
      const { fileUrl, whatDoYouWant, aiToPaste, filePublic } = button.dataset;

      let fileUrlToSend = "";
      if (filePublic == "0") {
        fileUrlToSend = `data:image/jpeg;base64,${fileUrl}`;
      }
      else
      {
        fileUrlToSend = fileUrl;
      }

      const elementToPaste = document.querySelector(
        `[data-formengine-input-name='${aiToPaste}']`
      );

      const data = {
         model: "gpt-4-turbo",
        messages: [
          {
            role: "user",
            content: [
              {
                type: "text",
                text: whatDoYouWant,
              },
              {
                type: "image_url",
                image_url: {
                  url: fileUrlToSend,
                },
              },
            ],
          },
        ],
        max_tokens: 300,
      };

      fetchOpenAICompletion(data)
        .then((data) => {
          elementToPaste.value = data.choices[0].message.content;
          elementToPaste.dispatchEvent(new Event("change", { bubbles: true }));
          button.disabled = false;
          Icons.getIcon(iconOn, Icons.sizes.small).then((icon) => {
            button.replaceChild(document.createRange().createContextualFragment(icon), button.querySelector(".t3js-icon"));
          });
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    });
  });
}

AiFormsImage();
