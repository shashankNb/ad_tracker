const trackingPixel = function() {
    let params = {};
    window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,
        function(_, key, value) {
            return params[key] = value;
        });

    const trackBtnElement = document.getElementsByClassName('tracking_btn');
    if(params.hasOwnProperty('s1')) {
        for(let i = 0; i < trackBtnElement.length; i++) {
            let link = trackBtnElement[i].getAttribute('href');
            const cid = params['s1'];
            link = link.replace('[s1]', cid);
            trackBtnElement[i].setAttribute('href', link);
        }
    } else {
        const year = new Date().getFullYear().toString();
        const month = new Date().getMonth().toString();
        const day = new Date().getDay().toString();
        const seconds = new Date().getSeconds().toString();
        const twoDigitRandom = Math.floor(Math.random() * 90 + 10);
        for(let i = 0; i < trackBtnElement.length; i++) {
            let link = trackBtnElement[i].getAttribute('href');
            const url = link.split('?')[0];
            const finalUrl = url.replace('[s1]', year + month + day + seconds + twoDigitRandom);
            trackBtnElement[i].setAttribute('href', finalUrl);
        }
    }
}
