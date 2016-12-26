/*global $*/
var files;

$(document).ready(function(){
    $('#file').on('change', prepareUpload);
    
    $('.submitter').on('click', startUpload);
});

function prepareUpload(event){
    files = $('#file').prop('files');
}

function startUpload(event){
    event.stopPropagation();
    event.preventDefault();
    
    //spinner?
    
    var data = new FormData();
    
    var taskNumber = parseInt($('#task :selected').text());
    
    console.log(taskNumber);
    
    if(files.length == 1){
        data.append('solution', files[0], files[0].name);
        data.append('taskNumber', taskNumber);
        
        //Do not get it, actually
        $.ajax({
            url:'/fileSaving',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            success: function(data){
                if(typeof data.error === 'undefined')
                {
                    // Success so call function to process the form
                    submitForm(event, data);
                }
                else
                {
                    console.log('SubmitForm SUCCESS: ERRORS: ' + data.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                // end spinner
                console.log('SubmitForm ERROR: ERRORS: ' + textStatus + ' ' + errorThrown);

            }
        });
    }else{
        alert("You are allowed upload only a single file.");
    }
}

/*global $form*/
function submitForm(event, data){
    console.log('Remember to figure out what the heck happened here and why you neede this piece of code');
    /*// Create a jQuery object from the form
    $form = $(event.target);

    // Serialize the form data
    var formData = $form.serialize();

    // You should sterilise the file names
    $.each(data.files, function(key, value)
    {
        formData = formData + '&filenames[]=' + value;
    });
    
    console.log(formData);
    
    $.ajax({
        url: '/fileSaving',
        type: 'POST',
        data: formData,
        cache: false,
        dataType: 'json',
        success: function(data, textStatus, jqXHR)
        {
            if(typeof data.error === 'undefined')
            {
                // Success so call function to process the form
                console.log(data);
            }
            else
            {
                // Handle errors here
                console.log('SubmitForm SUCCESS: ERROR: ' + data.error);
            }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            console.log('SubmitForm ERROR: ERRORS: ' + textStatus);
        },
        complete: function()
        {
            // STOP LOADING SPINNER
        }
    });*/
}