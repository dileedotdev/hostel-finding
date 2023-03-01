export function executeRecaptchaV3(action) {
    return new Promise((resolve, reject) => {
        window.grecaptcha.ready(() => {
            window.grecaptcha
                .execute(import.meta.env.VITE_RECAPTCHA_V3_SITE_KEY, { action })
                .then((token) => {
                    resolve(token);
                })
                .catch((error) => {
                    reject(error);
                });
        });
    });
}
