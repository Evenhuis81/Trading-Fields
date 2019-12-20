export function stripe() {
    if ($("#card-element").length > 0) {
        console.log("ye");
        const stripe = Stripe(process.env.MIX_STRIPE_KEY);
        const elements = stripe.elements();
        const cardElement = elements.create("card");
        cardElement.mount("#card-element");

        const cardHolderName = document.getElementById("card-holder-name");
        const cardButton = document.getElementById("card-button");
        const clientSecret = cardButton.dataset.secret;

        const plan = document.getElementById("subscription-plan").value;

        cardButton.addEventListener("click", async e => {
            const { setupIntent, error } = await stripe.handleCardSetup(
                clientSecret,
                cardElement,
                {
                    payment_method_data: {
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );

            if (error) {
                // Display "error.message" to the user...
            } else {
                // The card has been verified successfully...
                console.log("handling success", setupIntent.payment_method);

                Axios.post("/subscribe", {
                    payment_method: setupIntent.payment_method,
                    plan: plan
                }).then(data => {
                    location.replace("/paymentsuccess");
                });
            }
        });
    }
}
