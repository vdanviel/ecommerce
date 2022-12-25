if (window.location.pathname == "/ecommerce/admin/products/create") {

    function previewfile() {
        
        const preview = document.querySelector("#img-preview");
        const fileinput = document.querySelector("#imgproduct").files[0];

        const reader = new FileReader();

        reader.addEventListener("load", function(){
            preview.src = reader.result;
        });

        if (fileinput) {
            reader.readAsDataURL(fileinput);
        }

    }


}