    const html5QrCode = new Html5Qrcode(/* element id */ "reader");
    // File based scanning
    const fileinput = document.getElementById('qr-input-file');

    fileinput.addEventListener('change', e => {
      if (e.target.files.length == 0) {
        // No file selected, ignore 
        return;
      }
      const qrResult = document.getElementById("qr-result");
      //const outputData = document.getElementById("outputData");
      const code_value = document.getElementById('code_value');
      const myform = document.getElementById("myform");

      const imageFile = e.target.files[0];

      const elem = document.getElementById('bin_code_val');
      // Scan QR Code
      html5QrCode.scanFile(imageFile, true)
      .then(decodedText => {
        // success, use decodedText
        console.log(decodedText);
        qrResult.hidden=false;

        code_value.value = decodedText;
        code_value.innerHTML = decodedText;
        elem.value += code_value.innerText;
        myform.hidden = false;
        /*const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('id', outputData.innerText);
        window.location.search = urlParams;
        //window.location.href = "localhost/scan_barcode_qr/update_add.php?id=" + outputData.innerText;*/
      })
      .catch(err => {
        // failure, handle it.
        console.log(`Error scanning file. Reason: ${err}`)
      });
    });