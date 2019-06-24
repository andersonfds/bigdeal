$.fn.extend({
    exists: function (callback) {
        if (this.length) callback.call(event);
        return this;
    }
})
$(document).ready(function () {

    $('.checkbox').click(function () {
        // Toggling whether is active or not
        $('.checkbox').toggleClass('active')
        // Getting if is active
        let value = $(this).hasClass('active') ? 1 : 0
        // Getting the name of the input
        let name = "input[name='" + $(this).data('for') + "']"
        // Synchronizing the values
        $(name).attr('value', value)

    }).exists(function () {
        let checkbox = $('.checkbox');
        let name = "input[name='" + checkbox.data('for') + "']"
        // Synchronizing the values
        let value = $(name).attr('value') === '1'
        // Toggling whether is active or not
        checkbox.toggleClass('active', value)
    })

    $('.favorite').click(function () {
        // Toggling the class
        $(this).toggleClass('fa far')
        // Sending the request
        $('#favorite-form').submit()
    })

    $('#favorite-form').submit(function (e) {
        // Avoids the page to restarts
        e.preventDefault()
        let favorite = $('.favorite')
        // Checking the needed operations
        let op = favorite.hasClass('fa') ? 'add' : 'remove'
        // Making a post request, on error revert the icon
        $.post($(this).attr('action') + op).fail(function () {
            // Toggling class back
            favorite.toggleClass('fa far')
        })
    })

    $('.user, .user-menu').click(function () {
        // Toggling the user menu
        $('.user-menu').fadeToggle(150)
    })

    $('.btn-car-full').click(function () {
        let image = $('.images > img')
        if ($(this).hasClass('fa-angle-right'))
            image.last().prependTo('.images')
        if ($(this).hasClass('fa-angle-left'))
            image.first().appendTo('.images')
    })

    $('.add-img-button').click(() => {
        // Triggering the click
        $('#hide').trigger('click')
    })

    // Calling the function has files
    $('#hide').change(hasFiles).exists(hasFiles)

    /** Checks if file exists and shows it */
    function hasFiles() {
        // Getting the files of the upload field
        let filePicker = $('#hide')[0].files
        // Limiting the requisition to 4 images
        if (filePicker.length > 4) msg('Selecione no máximo 4 arquivos')
        else display_images(filePicker)
    }

    function display_images(files) {
        // Getting the images container
        let container = $('.img-up-sec');
        for (let i = 0; i < files.length; i++) {
            // Getting the current file
            let file = files[i];
            // Checking if the type is an image
            if (file.type !== 'image/jpeg' && file.type !== 'image/png') {
                msg('Selecione apenas imagens JPEG/JPG ou PNG')
                break;
            }
            var img;
            // If it has any images, will replace it
            container.find('img').remove()
            // Viewing the images into the container
            if ((readFile(container, file)) === false) break
        }
    }

    function readFile(container, file) {
        // Creating a file reader
        let reader = new FileReader()
        reader.onload = (e) => {
            output = buildImage(container, e.target.result)
        }
        reader.readAsDataURL(file)
    }

    function buildImage(container, src) {
        // creating an image element
        let img = document.createElement('img');
        img.src = src
        img.onload = function () {
            // Checking if the image is smaller than 1024x1024
            if ((output = img.width <= 1024))
            // Checking if the image is an square
                if (img.width === img.height && output)
                // Changing the return value
                    container.append(img)
                else msg('Só serão salvas imagens quadradas!')
            else msg('Imagens precisam ser menores que 1024 x 1024')
        }
    }

    function msg(msg) {
        let container = $('.msg-container')
        container.fadeToggle()
        setTimeout(function () {
            container.fadeToggle()
        }, 1000 * 2)
        $('.msg').text(msg)
    }

})