/*const form = document.getElementById('generate-form');
const qr = document.getElementById('qrcode');
const qr_img_data = document.getElementById('qr_img_data');
const code_value = document.getElementById('code_value');
const qr_input_file = document.getElementById('qr-input-file');

// Button submit
const onGenerateSubmit = (e) => {
  e.preventDefault();

  clearUI();

  const bin_code = document.getElementById('bin_code').value;
  const size = document.getElementById('size').value;

  // Validate bin_code
  if (bin_code === '') {
    alert('QRコードの値を入力してください。');
  } else {

    showSpinner();
    // Show spinner for 1 sec
    setTimeout(() => {
      hideSpinner();
      generateQRCode(bin_code, size);

      // Generate the save button after the qr code image src is ready
      setTimeout(() => {
        // Get save bin_code
        const savebin_code = qr.querySelector('img').src;
        //add text to form input
        qr.querySelector('img').classList = 'border border-2';
        qr_img_data.value = savebin_code;

        code_value.value = bin_code;
        
        // Create save button
        createSaveBtn(savebin_code);
        deteleBtn();
      }, 50);
    }, 1000);
  }
};

// Generate QR code
const generateQRCode = (bin_code, size) => {
  const qr_code = new QRCode('qrcode', {
    text: bin_code,
    width: size,
    height: size,
  });
};

// Clear QR code and save button
const clearUI = () => {
  qr.innerHTML = '';
  qr_img_data.value = '';
  code_value.value = '';
  qr_input_file.value='';
  const saveBtn = document.getElementById('save-link');
  const delete_ui = document.getElementById('delete_ui');
  if (saveBtn) {
    saveBtn.remove();
    delete_ui.remove();
  }
};
*/
// Show spinner
const showSpinner = () => {
  const spinner = document.getElementById('spinner');
  spinner.style.display = 'block';
};

// Hide spinner
const hideSpinner = () => {
  const spinner = document.getElementById('spinner');
  spinner.style.display = 'none';
};

// Create save button to download QR code as image
const createSaveBtn = (savebin_code) => {
  const link = document.createElement('a');
  link.id = 'save-link';
  link.classList =
    'btn btn-primary me-1';
  link.href = savebin_code;
  link.download = 'qrcode';
  link.innerHTML = '保存する';
  document.getElementById('generated').appendChild(link);
};
const deteleBtn = () => {
  const ele = document.createElement('a');
  ele.id = 'delete_ui';
  ele.classList =
    'btn btn-danger';
  ele.innerHTML = '消去';
  ele.addEventListener('click', function handleClick(event) {
  clearUI();
  });
  document.getElementById('generated').appendChild(ele);
};

hideSpinner();

//input image function
              window.onload=function(){
                let imgInput = document.getElementById('image-input');
                  if(imgInput) {
                  imgInput.addEventListener('change', function (e) {
                      if (e.target.files) {
                          let imageFile = e.target.files[0];
                          var reader = new FileReader();
                          clearIMG();
                          reader.onload = function (e) {
                              var img = document.createElement("img");
                              img_base64 = document.getElementById('img_base64');
                              img_base64.value = "";
                              img.onload = function (event) {
                                  // Dynamically create a canvas element
                                  var canvas = document.createElement("canvas");
                                  
                                  var MAX_WIDTH = 250;
                                  var MAX_HEIGHT = 250;
                                  var width = img.width;
                                  var height = img.height;
                                  if (width > height) {
                                    if (width > MAX_WIDTH) {
                                        height *= MAX_WIDTH / width;
                                        width = MAX_WIDTH;
                                    }
                                  }
                                  else {
                                      if (height > MAX_HEIGHT) {
                                          width *= MAX_HEIGHT / height;
                                          height = MAX_HEIGHT;
                                    }
                                  }
                                  canvas.width = width;
                                  canvas.height = height;
                                  var ctx = canvas.getContext("2d");
                                  ctx.drawImage(img, 0, 0, width, height);
                                  // Show resized image in preview element
                                  var dataurl = canvas.toDataURL(imageFile.type);
                                  img_base64.value = dataurl;
                                  document.getElementById("preview").src = dataurl;
                                  deteleBtn_img_input();
                              }
                              img.src = e.target.result;
                          }
                          reader.readAsDataURL(imageFile);
                      }
                  });
                  }
              };
//input image function delete iamge and base64 data
const deteleBtn_img_input = () => {
  const ele = document.createElement('a');
  ele.id = 'delete_input_img';
  ele.classList =
    'btn';
  ele.innerHTML = '<i class="bi bi-x-square"></i>';
  ele.addEventListener('click', function handleClick(event) {
  clearIMG();
  });
  document.getElementById('file_img_upload').appendChild(ele);
};
const clearIMG = () => {
  document.getElementById("preview").src = "";
  var deteleBtn_img_input = document.getElementById("delete_input_img");
  var delete_base64data = document.getElementById("img_base64");
  if (deteleBtn_img_input) {deteleBtn_img_input.remove();
    delete_base64data.value = " ";
    }
};

/*form.addEventListener('submit', onGenerateSubmit);

qr_input_file.addEventListener('click', function handleClick(event) {
  clearUI();
  });

var hidden = true;
const toggler = document.getElementById('toggler');
toggler.value = '開';
function showhide() {
  hidden = !hidden;
  a = document.getElementById('togglee');
  if(hidden) {
    a.style.visibility = 'hidden';
    toggler.value = '開';

  } else {
    a.style.visibility = 'visible';
    toggler.value = '閉';
  }
}
*/
