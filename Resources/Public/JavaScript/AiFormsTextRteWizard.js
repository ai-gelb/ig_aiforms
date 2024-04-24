import { fetchOpenAICompletion } from "@igelb/ig-aiforms/FetchAi.js";

function AiFormsText() {
  const clickButtons = document.querySelectorAll(".igjs-form-text-rte-ai");

  clickButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
      button.disabled = true;
      const { aiToRead, whatDoYouWant, aiToPaste } = button.dataset;
      const arrayAiToRead = aiToRead.split(",");

      let aiContent = "";

      arrayAiToRead.forEach((element) => {
        aiContent += ` ${document.querySelector(`[name='${element}']`).value}`;
      });

      const data = {
        model: "gpt-4-turbo",
        messages: [
          { role: "system", content: whatDoYouWant },
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
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    });
  });
}

AiFormsText();
