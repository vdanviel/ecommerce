//img previwe js system (http://localhost/ecommerce/admin/products/2)
const regex = /[0-9]/;//regex looking for a number in a string
if (window.location.pathname == "/ecommerce/admin/products/create" || regex.test(window.location.pathname) === true) {

    function previewfile() {
        
        const preview = document.querySelector("#img-preview");//the img HTML element
        const fileinput = document.querySelector("#imgproduct").files[0];//the file in the inpur file

        const reader = new FileReader();

        reader.addEventListener("load", function(){
            preview.src = reader.result;
        });

        if (fileinput) {
            reader.readAsDataURL(fileinput);
        }

    }

}

//list-product-preview-name (http://localhost/ecommerce/lista-produtos/1)
function previewproductname() {
    
    let text = document.getElementById("productname");

    text.style.display = "flex";

}

//next button of lists is desactivated
function button_next_off(){

    var btn = document.getElementById('next-page');

    btn.style.display = "none"

}