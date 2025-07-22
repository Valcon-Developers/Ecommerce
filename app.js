const paypalButtons = window.paypal.Buttons({
   style: {
        shape: "rect",
        layout: "vertical",
        color: "gold",
        label: "paypal",
    },
   async createVaultSetupToken() {
        try {
            const response = await fetch("/api/vault", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                // use the "body" param to optionally pass additional token information
                body: JSON.stringify({
                    payment_source: {
                        paypal: {
                            usage_type: "MERCHANT",
                            experience_context: {
                                return_url: "https://example.com/returnUrl",
                                cancel_url: "https://example.com/cancelUrl",
                            },
                        },
                    },
                }),
            });

            const setupTokenData = await response.json();

            if (setupTokenData.id) {
                return setupTokenData.id;
            }
            const errorDetail = setupTokenData?.details?.[0];
            const errorMessage = errorDetail
                ? `${errorDetail.issue} ${errorDetail.description} (${setupTokenData.debug_id})`
                : JSON.stringify(setupTokenData);

            throw new Error(errorMessage);
        } catch (error) {
            console.error(error);
            // resultMessage(`Could not create Setup token...<br><br>${error}`);
        }
    },
   async onApprove(data, actions) {
        try {
            const response = await fetch(`/api/vault/payment-tokens`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: {
                    payment_source: {
                        token: {
                            id: data.vaultSetupToken,
                            type: "SETUP_TOKEN",
                        },
                    },
                },
            });

            const paymentTokenData = await response.json();
            const errorDetail = paymentTokenData?.details?.[0];

            if (errorDetail) {
                throw new Error(
                    `${errorDetail.description} (${paymentTokenData.debug_id})`
                );
            } else {
                console.log(
                    "Payment Token",
                    paymentTokenData,
                    JSON.stringify(paymentTokenData, null, 2)
                );
            }
        } catch (error) {
            console.error(error);
            resultMessage(
                `Sorry, could not create tokenized payment source...<br><br>${error}`
            );
        }
    },
});

// Example function to show a result to the user. Your site's UI library can be used instead.
function resultMessage(message) {
    const container = document.querySelector("#result-message");
    container.innerHTML = message;
}