import { useState, useEffect } from "react";

const RecaptchaSiteKey = window?.__WP?.recaptcha;
const RecaptchaUrl = "https://recaptcha.net/recaptcha/api.js";

window._recaptchaLoaded = function () {
  window.recaptcha_loaded = true;
};

export function Recaptcha({ token, action = "leadform" }) {
  const [grecaptcha, setGrecaptcha] = useState(window.grecaptcha);

  useEffect(() => {
    if (RecaptchaSiteKey && !window.recaptcha_loaded) {
      const s = document.createElement("script");
      s.type = "text/javascript";
      s.async = true;
      s.defer = true;
      s.onload = () => setGrecaptcha(window.grecaptcha);
      s.src = `${RecaptchaUrl}?onload=_recaptchaLoaded&render=${RecaptchaSiteKey}`;
      document.getElementsByTagName("HEAD")[0].appendChild(s);
    }
  }, []);

  if (token && RecaptchaSiteKey && grecaptcha) {
    token.current = {
      get: function () {
        const TokenPromise = new Promise((res, rej) => {
          if (RecaptchaSiteKey && grecaptcha) {
            const r = () => {
              grecaptcha.execute(RecaptchaSiteKey, { action }).then((t) => {
                res(t);
              }, rej);
            };

            grecaptcha.ready(r);
          }
        });

        return TokenPromise;
      },
    };
  }

  return null;
}

export default Recaptcha;
