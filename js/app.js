$('body').on('click', '.modal-show', function (event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        title = me.attr('title');

    $('#modal-title').text(title);
    $('#modal-btn-save').removeClass('hide').text(me.hasClass('edit') ? 'Update' : 'Simpan');
    
    $.ajax({
        url: url,
        dataType: 'html',
        success: function (response) {
            $('#modal-body').html(response);
            // console.log(response)

            $('#jumlah_simpan,#jumlah_pinjaman,#biaya_adm,#biaya_cppu,#pokok,#jasa,#total_angsuran,#simpanan_pokok,#simpanan_wajib,#simpanan_sukarela,#simpanan_harkop,#simpanan_kematian,#saldo_hutang,#total_bayar').divide({
                delimiter: '.',
                divideThousand: false
            }); 
            
           
        }
    });

    $('#modal').modal('show');
    
    
});

//Button SAVE
$('#modal-btn-save').click(function (event) {
    
    event.preventDefault();

    var form = $('#modal-body form'),
        url = form.attr('action'),
        method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';

    form.find('.help-block').remove(); //hapus tanda validasi ketika true
    form.find('.form-group').removeClass('has-error'); //hapus tanda validasi ketika true

    $.ajax({
        url : url,
        method: 'POST', // type: method,   FormData tidak support PUT
        // data : form.serialize(), //serialize() tidak mendukung upload file
        data: new FormData(form [0]), //form yang pertama dicari
        contentType : false,
        async: false, // masukan true jika pake validasi file .jpg //serialize & formdata
        processData : false,  //serialize & formdata
        cache: false, //serialize & formdata
        success: function ($data) {
            form.trigger('reset');
            $('#modal').modal('hide');
            var $datatable = $('#datatable').DataTable();
            $datatable.ajax.reload(null,false);
            // window.location.reload(); // reload tambahan 
            // location.reload(); // reload tambahan 

            // if (typeof ($data.foto) != "undefined" && $data.foto !== null){
            //     $('.user-image').removeAttr('src');
            //     $('.user-image').attr('src', 'http://localhost:8000/assets/img/profil/'.$data.foto);
            // }
            
            swal({
                type : 'success',
                title : 'Success!',
                text : 'Data telah tersimpan!'
            });    
        },
        error : function (xhr) {
            var res = xhr.responseJSON;
            if ($.isEmptyObject(res) == false) {
                $.each(res.errors, function (key, value) {
                    $('#' + key)
                        .closest('.form-group')
                        .addClass('has-error')
                        .append('<span class="help-block"><strong>' + value + '</strong></span>');
                });
            }
        }
    })
});

//Button Batal
$('body').on('click', '.btn-batal', function (event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        title = me.attr('title'),
        csrf_token = $('meta[name="csrf-token"]').attr('content');

    swal({
        title: 'Anda yakin akan ' + title + ' ?',
        text: 'Tuliskan alasan pembatalan!',
        type: 'warning',
        input: 'text',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.value != '') {
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': csrf_token,
                    'ket_pembatalan': result.value
                },
                success: function (response) {
                    
                    $('#datatable').DataTable().ajax.reload();
                    swal({
                        type: 'success',
                        title: 'Success!',
                        text: 'Data has been deleted!'
                    });
                },
                error: function (xhr) {
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    });
                }
            });
        } else {
            swal({
                type: 'error',
                title: 'Oops...',
                text: 'Tolong Isi Alasan!'
            });
        }
    });
});

//Button DELETE
$('body').on('click', '.btn-delete', function (event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        title = me.attr('title'),
        csrf_token = $('meta[name="csrf-token"]').attr('content');

    swal({
        title: 'Anda yakin akan ' + title + ' ?',
        text: 'Tuliskan alasan pembatalan!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.value) {

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    '_method': 'DELETE',
                    '_token': csrf_token,
                },
                success: function (response) {

                    $('#datatable').DataTable().ajax.reload();
                    swal({
                        type: 'success',
                        title: 'Success!',
                        text: 'Data has been deleted!'
                    });
                },
                error: function (xhr) {
                    swal({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    });
                }
            });
        }
    });
});

//Button Show
$('body').on('click', '.btn-show', function (event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        title = me.attr('title');

    $('#modal-title').text(title);
    $('#modal-btn-save').addClass('hide');

    $.ajax({
        url: url,
        dataType: 'html',
        success: function (response) {
            $('#modal-body').html(response);
        }
    });

    $('#modal').modal('show');
});

