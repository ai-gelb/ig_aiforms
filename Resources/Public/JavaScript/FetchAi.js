
function fetchOpenAICompletion(requestData) {
  return fetch(TYPO3.settings.ajaxUrls.igelb_ig_aiforms_ai, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(requestData),
  })
  .then(response => response.json());
}

export { fetchOpenAICompletion };
