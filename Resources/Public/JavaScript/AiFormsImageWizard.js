import { fetchOpenAICompletion } from "@igelb/ig-aiforms/FetchAi.js";
import { fetchFile } from "@igelb/ig-aiforms/FetchFile.js";
import Notification from "@typo3/backend/notification.js";
import Icons from "@typo3/backend/icons.js";

function AiFormsImage() {
  const clickButtons = document.querySelectorAll(".igjs-form-ai");
  const iconOn = "actions-infinity";
  const iconOff = "spinner-circle";

  clickButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      button.disabled = true;

      // Replace button icon with loading icon
      Icons.getIcon(iconOff, Icons.sizes.small).then((icon) => {
        const iconPlaceholder = button.querySelector(".t3js-icon");
        const iconFragment = document
          .createRange()
          .createContextualFragment(icon);
        button.replaceChild(iconFragment, iconPlaceholder);
      });

      // Destructure data attributes from the button
      const { file, whatDoYouWant, aiToPaste, language } = button.dataset;

      // Select the element to paste response into
      const elementToPaste = document.querySelector(
        `[data-formengine-input-name='${aiToPaste}']`
      );

      // Fetch the file
      fetchFile(file).then((dataFile) => {
        if (dataFile.status === "ok") {
          let FileBase64 = `data:image/jpeg;base64,${dataFile.base64}`;
          let FileText = dataFile.text;

          let data = {};

          console.log(dataFile);

          if (dataFile.extension === "pdf") {
            data = {
              model: "gpt-4-turbo",
              messages: [
                {
                  role: "system",
                  content: whatDoYouWant + ". Always respond in: " + language,
                },
                { role: "user", content: FileText },
              ],
              temperature: 0.5,
              top_p: 1,
            };
          } else {
            data = {
              model: "gpt-4-turbo",
              messages: [
                {
                  role: "user",
                  content: [
                    {
                      type: "text",
                      text: `${whatDoYouWant}. Always respond in: ${language}`,
                    },
                    {
                      type: "image_url",
                      image_url: { url: FileBase64 },
                    },
                  ],
                },
              ],
              max_tokens: 1500,
            };
          }

          // Fetch completion from OpenAI
          fetchOpenAICompletion(data)
            .then((data) => {
              elementToPaste.value = data.choices[0].message.content;
              elementToPaste.dispatchEvent(
                new Event("change", { bubbles: true })
              );
              button.disabled = false;

              // Replace loading icon with original icon
              Icons.getIcon(iconOn, Icons.sizes.small).then((icon) => {
                const iconPlaceholder = button.querySelector(".t3js-icon");
                const iconFragment = document
                  .createRange()
                  .createContextualFragment(icon);
                button.replaceChild(iconFragment, iconPlaceholder);
              });
            })
            .catch((error) => {
              button.disabled = false;
              Icons.getIcon(iconOn, Icons.sizes.small).then((icon) => {
                button.replaceChild(
                  document.createRange().createContextualFragment(icon),
                  button.querySelector(".t3js-icon")
                );
              });
              Notification.error("AI error", "", 10, []);
            });
        }
        if (dataFile.status === "error") {
          button.disabled = false;
          // Replace loading icon with original icon
          Icons.getIcon(iconOn, Icons.sizes.small).then((icon) => {
            const iconPlaceholder = button.querySelector(".t3js-icon");
            const iconFragment = document
              .createRange()
              .createContextualFragment(icon);
            button.replaceChild(iconFragment, iconPlaceholder);
          });

          Notification.error("AI error", dataFile.message, 10, []);
        }
      });
    });
  });
}

// Initialize the script when document is ready
if (document.readyState !== "loading") {
  AiFormsImage();
} else {
  document.addEventListener("DOMContentLoaded", AiFormsImage);
}
