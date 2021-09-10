$('.save-settings-button').on('click', (event) => {
    let destination = $(event.target).attr('data-route-name')

    let inputs = $('.settings_inputs')
    let form_data = {}

    inputs.map((el) => {
        setting_name = $(el).attr('name')
        setting_value = $(el).val()
        form_data[setting_name] = setting_value
    })
        axios({
            url: destination,
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: form_data

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


