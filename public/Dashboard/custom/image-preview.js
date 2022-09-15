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

$(".front_side_image").change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".front_side_image-preview").attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});

$(".back_side_image").change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".back_side_image-preview").attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});

$(".right_side_image").change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".right_side_image-preview").attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});

$(".left_side_image").change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".left_side_image-preview").attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});

$(".inside_vehicle_image").change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".inside_vehicle_image-preview").attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});

$(".vehicle_dashboard_image").change(function () {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(".vehicle_dashboard_image-preview").attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    }
});

