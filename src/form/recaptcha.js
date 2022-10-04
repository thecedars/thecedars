const RecaptchaSiteKey = process.env.REACT_APP_RECAPTCHA_SITE_KEY;
const RecaptchaUrl = 'https://recaptcha.net/recaptcha/api.js';

export default function loadRecaptcha(action = 'leadform') {
	return new Promise((res, rej) => {
		if (!RecaptchaSiteKey) {
			res(null);
		}

		if (window.grecaptcha) {
			window.grecaptcha
				.execute(RecaptchaSiteKey, { action })
				.then((token) => {
					res(token);
				}, rej);
		} else {
			rej(new Error('Unable to resolve captcha.'));
		}
	});
}

function RecaptchaScript() {
	if (RecaptchaSiteKey) {
		const s = document.createElement('script');
		s.type = 'text/javascript';
		s.async = true;
		s.defer = true;
		s.src = `${RecaptchaUrl}?&render=${RecaptchaSiteKey}`;
		document.getElementsByTagName('HEAD')[0].appendChild(s);
	}
}

RecaptchaScript();
