require(["jquery"], function ($) {
    $(document).ready(function () {
        $(".towishlist").on("click", function (event) {
           event.preventDefault();
            var productId = $(this).data("product-id");
            var formKey = $('input[name="form_key"]').val();
            $.ajax({
                type: "POST",
                url: "/wishlist/index/add/product/" + productId + "/",
                data: {
                    product: productId,
                    form_key: formKey,
                },
                success: function (data) {
                    window.location.href = "/wishlist/index/index/";
                }
            });
        });
        $(".tocart").on("click", function (event) {
             event.preventDefault();
             var productId = $(this).data("product-id");
             var formKey = $('input[name="form_key"]').val();
             $.ajax({
                 type: "POST",
                 url: "/checkout/cart/add/product/" + productId + "/",
                 data: {
                     product: productId,
                     form_key: formKey,
                 },
                 success: function (data) {
                     window.location.href = "/checkout/cart/index/";
                 },
            });
        });
         $(".color").on("click", function (event) {
             event.preventDefault();
             var productId = $(this).data("option-id");
             var productToChange = $(this).closest(".product-item").find(".product-item-photo");
             $.ajax({
                 type: "GET",
                 url: "swatches/ajax/media/?product_id="+ productId+"&isAjax=true",
                 datatype: JSON,
                 success: function (data) {
                  productToChange.find(".product-image-photo").attr("src", data.large);
                 },
             });
         });
    });
});
