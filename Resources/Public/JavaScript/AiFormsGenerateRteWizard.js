import { fetchOpenAICompletion } from "@igelb/ig-aiforms/FetchAi.js";
import { fetchFile } from "@igelb/ig-aiforms/FetchFile.js";
import Notification from "@typo3/backend/notification.js";
import Icons from "@typo3/backend/icons.js";

function AiFormsText() {
  const clickButtons = document.querySelectorAll(".igjs-form-text-rte-ai");
  const iconOn = "actions-infinity";
  const iconOff = "spinner-circle";

  // Hilfsfunktion, um Icon eines Buttons zu ersetzen
  const replaceButtonIcon = async (button, iconName) => {
    const icon = await Icons.getIcon(iconName, Icons.sizes.small);
    button.replaceChild(
      document.createRange().createContextualFragment(icon),
      button.querySelector(".t3js-icon")
    );
  };

  // Hilfsfunktion, um die AI-Antwort in den passenden Editor zu setzen
  const setEditorContent = (sourceId, content) => {
    const editorElements = Array.from(
      document.querySelectorAll(".ck-editor__editable")
    );
    const targetEditor = editorElements.find((element) => {
      const instance = element.ckeditorInstance;
      return instance?.sourceElement?.id === sourceId;
    });

    if (targetEditor) {
      targetEditor.ckeditorInstance.setData(content);
      console.log("Editor gefunden:", targetEditor.ckeditorInstance);
    } else {
      console.error("Kein Editor mit dieser ID gefunden");
    }
  };

  clickButtons.forEach((button) => {
    button.addEventListener("click", async () => {
      button.disabled = true;
      await replaceButtonIcon(button, iconOff);

      const { aiToRead, aiToReadPdf, whatDoYouWant, aiToPaste, language } =
        button.dataset;
      const aiContent = aiToRead
        .split(",")
        .map((element) => document.querySelector(`[name='${element}']`).value)
        .join(" ");

      let pdfTEXT = "";
      if (aiToReadPdf > 0) {
        const PDF = await fetchFile(aiToReadPdf);

        if (PDF.status === "ok") {
          pdfTEXT = await PDF.text;
          pdfTEXT = ". Use this PDF content as the source: " + pdfTEXT;
        }
        if (PDF.status === "error") {
          console.error("Fehler beim Lesen der PDF-Datei:", PDF.message);
          Notification.error("PDF error", "", 10, []);
        }
      }

      const requestData = {
        model: "gpt-4-turbo",
        messages: [
          {
            role: "system",
            content: `${whatDoYouWant}. Always respond in: ${language}`,
          },
          { role: "user", content: aiContent + " , " + pdfTEXT },
        ],
        temperature: 0.5,
        top_p: 1,
      };

      try {
        const responseData = await fetchOpenAICompletion(requestData);
        const sourceId =
          "data" + aiToPaste.replace(/\[/g, "_").replace(/\]/g, "_");
        setEditorContent(sourceId, responseData.choices[0].message.content);
      } catch (error) {
        console.error("Fehler bei der AI-Anfrage:", error);
        Notification.error("AI error", "", 10, []);
      } finally {
        button.disabled = false;
        await replaceButtonIcon(button, iconOn);
      }
    });
  });
}

// Initialisierung des Skripts, wenn das Dokument geladen ist
if (document.readyState !== "loading") {
  AiFormsText();
} else {
  document.addEventListener("DOMContentLoaded", AiFormsText);
}
