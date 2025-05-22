import { fetchOpenAICompletion } from "@igelb/ig-aiforms/FetchAi.js";
import Notification from "@typo3/backend/notification.js";
import { fetchPage } from "@igelb/ig-aiforms/FetchPage.js";
import Icons from "@typo3/backend/icons.js";

function AiFormsPageText() {
  const clickButtons = document.querySelectorAll(".igjs-form-page-text-ai");
  const iconOn = "actions-infinity";
  const iconOff = "spinner-circle";
  console.log("juan");

  clickButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      button.disabled = true;
      Icons.getIcon(iconOff, Icons.sizes.small).then((icon) => {
        button.replaceChild(
          document.createRange().createContextualFragment(icon),
          button.querySelector(".t3js-icon")
        );
      });
      const { pageUid, whatDoYouWant, aiToPaste, language } = button.dataset;

      fetchPage(pageUid)
        .then((dataPage) => {
          const elementToPaste = document.querySelector(
            `[data-formengine-input-name='${aiToPaste}']`
          );
          const data = {
            model: "gpt-4-turbo",
            messages: [
              {
                role: "system",
                content: whatDoYouWant + ". Always respond in: " + language,
              },
              { role: "user", content: dataPage.content },
            ],
            temperature: 0.5,
            top_p: 1,
          };

          fetchOpenAICompletion(data)
            .then((data) => {
              elementToPaste.value = data.choices[0].message.content;
              elementToPaste.dispatchEvent(
                new Event("change", { bubbles: true })
              );
              button.disabled = false;
              Icons.getIcon(iconOn, Icons.sizes.small).then((icon) => {
                button.replaceChild(
                  document.createRange().createContextualFragment(icon),
                  button.querySelector(".t3js-icon")
                );
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
    });
  });
}

// Initialize the script when document is ready
if (document.readyState !== "loading") {
  AiFormsPageText();
} else {
  document.addEventListener("DOMContentLoaded", AiFormsText);
}
