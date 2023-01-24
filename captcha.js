const https = require('https'),
    querystring = require('querystring');

const SMARTCAPTCHA_SERVER_KEY = "Dkh2GIA5lWccFD0mWOWUoO7gZMFWb9VezQvaUtFc";


function check_captcha(token, callback) {
    const options = {
        hostname: 'captcha-api.yandex.ru',
        port: 443,
        path: '/validate?' + querystring.stringify({
            secret: SMARTCAPTCHA_SERVER_KEY,
            token: token,
            ip: '127.0.0.1', // Нужно передать IP пользователя.
                             // Как правильно получить IP зависит от вашего фреймворка и прокси.
        }),
        method: 'GET',
    };
    const req = https.request(options, (res) => {
        res.on('data', (content) => {
            if (res.statusCode !== 200) {
                console.error(`Allow access due to an error: code=${res.statusCode}; message=${content}`);
                callback(true);
                return;
            }
            callback(JSON.parse(content).status === 'ok');
        });
    });
    req.on('error', (error) => {
        console.error(error);
        callback(true);
    });
    req.end();
}


let token = "<token>";
check_captcha(token, (passed) => {
    if (passed) {
        console.log("Passed");
    } else {
        console.log("Robot");
    }
});
