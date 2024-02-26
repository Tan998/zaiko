
    const html5QrCode = new Html5Qrcode(/* element id */ "reader");
    // File based scanning
    const fileinput = document.getElementById('qr-input-file');

    fileinput.addEventListener('change', e => {
      const elem = document.getElementById('bin_code_val');
      elem.value = "";

      if (e.target.files.length == 0) {
        // No file selected, ignore 
        return;
      }
      //const outputData = document.getElementById("outputData");
      let form = document.getElementById('form_search_item');
      const myform = document.getElementById("myform");
      const imageFile = e.target.files[0];
      // Scan QR Code
      html5QrCode.scanFile(imageFile, true)
      .then(decodedText => {
        // success, use decodedText
        console.log(decodedText);
        showSpinner();
                // Show spinner for 1 sec
                setTimeout(() => {
                  hideSpinner();
                  elem.value += decodedText;
                  if (myform) {myform.hidden = false;}
                  if (form) {
                    form.action = "?m=item&a=item_detail&item_code="+`${decodedText}`;
                    setTimeout(function(){document.getElementById("button-addon2").click();},500);
                  }
                  setTimeout(function(){document.getElementById("button-addon2").click();},500);
                }, 600);
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