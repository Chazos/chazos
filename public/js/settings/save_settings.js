$('.save-settings-button').on('click', (event) => {
    let destination = $(event.target).attr('data-route-name')
    let form = $('.save-settings-form')
    let formData = new FormData(form[0])


        axios.post(destination, formData, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
      })
      .then(function (response) {
         if (response.data.status == 'success'){
            setSuccessAlert(response.data.message)

            setTimeout(()=> {
                window.location.reload()
            }, 2000)
         }
      })
      .catch(function (error) {
           setErrorAlert(error.toString())
      });
})


$('.save-email-button').on('click', (event) => {
    let destination = $(event.target).attr('data-route-name')
    let form = $('.save-mail-settings')
    let formData = new FormData(form[0])

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

