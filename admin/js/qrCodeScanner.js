/*//const qrcode = window.qrcode;

const video = document.createElement("video");
const canvasElement = document.getElementById("qr-canvas");
const canvas = canvasElement.getContext("2d");

const qrResult = document.getElementById("qr-result");
const outputData = document.getElementById("code_value");
const btnScanQR = document.getElementById("btn-scan-qr");



let scanning = false;

qrcode.callback = res => {
  if (res) {
    outputData.innerText = res;
    scanning = false;
    console.log(outputData.innerText);
    const elem = document.getElementById('bin_code_val');
    const myform = document.getElementById("myform");
    elem.value += outputData.innerText;

    //set param move to update page with barcode id
    //const urlParams = new URLSearchParams(window.location.search);
    //urlParams.set('id', outputData.innerText);
    //window.location.search = urlParams;
    //window.location.href = "localhost/scan_barcode_qr/update_add.php?id=" + outputData.innerText;
    //console.log(query);

    video.srcObject.getTracks().forEach(track => {
      track.stop();
    });
    myform.hidden = false;
    qrResult.hidden = false;
    canvasElement.hidden = true;
    btnScanQR.hidden = false;

  }
};

btnScanQR.onclick = () => {
  navigator.mediaDevices
    .getUserMedia({ video: { facingMode: "environment" } })
    .then(function(stream) {
      scanning = true;
      qrResult.hidden = true;
      btnScanQR.hidden = true;
      canvasElement.hidden = false;
      video.setAttribute("playsinline", true); // required to tell iOS safari we don't want fullscreen
      video.srcObject = stream;
      video.play();
      tick();
      scan();
    });
};
function tick() {
  canvasElement.height = video.videoHeight;
  canvasElement.width = video.videoWidth;
  canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);

  scanning && requestAnimationFrame(tick);
}

function scan() {
  try {
    qrcode.decode();
  } catch (e) {
    setTimeout(scan, 300);
  }
}*/

const btnScanQR = document.getElementById("btn-scan-qr");
const outputData = document.getElementById("code_value");



function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete"
            || document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    btnScanQR.onclick = () => docReady(function () {
        var resultContainer = document.getElementById('qr-reader-results');
        var bin_code_val = document.getElementById("bin_code_val");
        let form = document.getElementById('form_search_item');
        bin_code_val.value = "";
        resultContainer.innerHTML = "";
        var lastResult, countResults = 0;
        btnScanQR.hidden = true;
        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
              html5QrcodeScanner.clear().then(_ => {
                  // the UI should be cleared here      
                }).catch(error => {
                  console.log("dmm");
                });
              showSpinner();
                // Show spinner for 1 sec
                setTimeout(() => {
                  hideSpinner();
                  if (form) {
                    form.action = "?m=item&a=item_detail&item_code="+`${decodedText}`;
                    setTimeout(function(){document.getElementById("button-addon2").click();},500);
                  }
                  setTimeout(function(){document.getElementById("button-addon2").click();},500);
                  ++countResults;
                  lastResult = decodedText;
                  // Handle on success condition with the decoded message.
                  console.log(`Scan result ${decodedText}`, decodedResult);
                  //resultContainer.innerHTML = `${decodedText}`;
                  bin_code_val.value += `${decodedText}`;
                  btnScanQR.hidden = false;
                }, 1000);
            }
        }
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 200 });
        html5QrcodeScanner.render(onScanSuccess);
    });

    //abcdef