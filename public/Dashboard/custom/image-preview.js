$(".image").change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".image-preview").attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});

$(".vehicle-image").change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".vehicle-image-preview").attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});

$(".license").change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".license-preview").attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});
