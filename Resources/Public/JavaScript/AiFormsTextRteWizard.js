import { fetchOpenAICompletion } from "@igelb/ig-aiforms/FetchAi.js";
import Icons from "@typo3/backend/icons.js";

function AiFormsText() {
  const clickButtons = document.querySelectorAll(".igjs-form-text-rte-ai");
  const iconOn = "actions-infinity";
  const iconOff = "spinner-circle";

  clickButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      button.disabled = true;
      Icons.getIcon(iconOff, Icons.sizes.small).then((icon) => {
        button.replaceChild(
          document.createRange().createContextualFragment(icon),
          button.querySelector(".t3js-icon")
        );
      });

      const { aiToRead, whatDoYouWant, aiToPaste, language } = button.dataset;
      console.log(aiToRead, aiToPaste);
      const arrayAiToRead = aiToRead.split(",");

      let aiContent = "";

      arrayAiToRead.forEach((element) => {
        aiContent += ` ${document.querySelector(`[name='${element}']`).value}`;
      });

      const data = {
        model: "gpt-4-turbo",
        messages: [
          {
            role: "system",
            content: whatDoYouWant + ". Always respond in: " + language,
          },
          { role: "user", content: aiContent },
        ],
        temperature: 0.5,
        top_p: 1,
      };

      fetchOpenAICompletion(data)
        .then((data) => {
          const editorElements = Array.from(
            document.querySelectorAll(".ck-editor__editable")
          );

          const findEditorBySourceId = (sourceId) => {
            let targetEditor = null;

            editorElements.forEach((element) => {
              const instance = element.ckeditorInstance;
              if (
                instance &&
                instance.sourceElement &&
                instance.sourceElement.id === sourceId
              ) {
                targetEditor = instance;
              }
            });

            return targetEditor;
          };

          const sourceId =
            "data" + aiToPaste.replace(/\[/g, "_").replace(/\]/g, "_");

          const myEditorInstance = findEditorBySourceId(sourceId);

          if (myEditorInstance) {
            console.log("Editor gefunden:", myEditorInstance);

            myEditorInstance.setData(data.choices[0].message.content);
          } else {
            console.error("Kein Editor mit dieser ID gefunden");
          }

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
    });
  });
}

// Initialize the script when document is ready
if (document.readyState !== "loading") {
  AiFormsText();
} else {
  document.addEventListener("DOMContentLoaded", AiFormsText);
}
