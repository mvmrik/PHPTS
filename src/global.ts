export async function tsFetch(option: { fetchUrl: string; formElement?: HTMLFormElement; postData?: Object }) {
	const fetchUrl = option.fetchUrl;
	const formElement = option.formElement;
	const postData = option.postData;

	const sentData = async () => {
		if (formElement != undefined && formElement.reportValidity()) {
			const formData = new FormData(formElement);

			if (option.postData) {
				Object.entries(option.postData).forEach(([key, value]) => {
					if (typeof value === "object" && !(value instanceof File)) {
						formData.append(key, JSON.stringify(value));
					} else {
						formData.append(key, value);
					}
				});
			}

			const response = await fetch(fetchUrl, {
				method: "POST",
				body: formData,
			});

			const msgResponse = await response.json();
			return msgResponse;
		}
	};

	// Define fetchData as a function expression
	const fetchData = async () => {
		const response = await fetch(fetchUrl, {
			method: "POST",
			body: JSON.stringify(postData),
		});

		const msgResponse = await response.json();
		return msgResponse;
	};

	if (formElement) {
		return sentData();
	} else {
		return fetchData();
	}
}
