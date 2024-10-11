
function fetchFile(requestData) {
  return fetch(TYPO3.settings.ajaxUrls.igelb_ig_aiforms_file, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(requestData),
  })
  .then(response => response.json());
}

export { fetchFile };
