$('.save-settings-button').on('click', (event) => {
    let destination = $(event.target).attr('data-route-name')

    let form = $('.save-settings-form')

    let formData = new FormData(form[0])


    // inputs.map((el) => {
    //     let settingName = $(el).attr('name')

    //     console.log("Test: " + settingName)
    //     console.log("Shit test")

    //     if ($(el).attr('type') == 'file') {
    //         formData.append(settingName, $(el)[0].files[0])
    //     }else{
    //         setting_value = $(el).val()
    //         formData.append(settingName, settingValue)
    //     }
    // })


        axios.post(destination, formData, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
      })
      .then(function (response) {
         if (response.data.status == 'success'){
            setSuccessAlert(response.data.message)
         }
      })
      .catch(function (error) {
           setErrorAlert(error.toString())
      });
})


