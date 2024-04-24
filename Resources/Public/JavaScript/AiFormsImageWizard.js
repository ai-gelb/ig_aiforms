import { fetchOpenAICompletion } from "@igelb/ig-aiforms/FetchAi.js";

function AiFormsImage() {
  const clickButtons = document.querySelectorAll(".igjs-form-ai");

  clickButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      button.disabled = true;
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
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    });
  });
}

AiFormsImage();
