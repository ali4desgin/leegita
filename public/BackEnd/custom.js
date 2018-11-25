function readIMG(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#image").change(function(){
    readIMG(this);
});


$(".confirmProccess").click(function(){
    alert("goog");
    return  confirm("are you sure ?");
})