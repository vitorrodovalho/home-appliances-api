@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                        Adicionar
                    </button>
                </div>
                <div class="card-body">
                    <table id="appliances" class="table table-bordered table-striped hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                {{--<th>Marca</th> --}}
                                <th>Voltagem</th>
                                <th width="60"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><span id="titleModal">Adicionar</span> Eletrodoméstico</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="id">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="name">Description</label>
                            <input type="text" class="form-control" id="description">
                        </div>
                        <div class="form-group">
                            <label for="name">Voltage</label>
                            <input type="number" class="form-control" id="voltage">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button id="adicionar" type="button" class="btn btn-primary">Adicionar</button>
                    <button id="update" type="button" class="btn btn-primary" style="display: none">Atualizar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        function clearFields(){
           $("#name").val('');
           $("#description").val('');
           $("#voltage").val('');
        }

        function editAppliance(id){
            $.ajax({
                type: 'GET',
                url: "{{ url('/') }}" + "/api/appliances/" + id,
                contentType: "application/json; charset=utf-8",
                dataType: 'JSON'
            }).done(function(data) {
                $("#id").val(data[0].id);
                $("#name").val(data[0].name);
                $("#description").val(data[0].description);
                $("#voltage").val(data[0].voltage);

                $("#adicionar").hide();
                $("#update").show();
                $("#titleModal").text('Atualizar');
                $("#staticBackdrop").modal('show');
            }).fail(function(jqXHR, textStatus, msg){
                Swal.fire({
                    title: "Erro",
                    text: jqXHR.responseJSON.message,
                    type: "error",
                    showConfirmButton: true,
                });
            });
        }

        function deleteAppliance(id){
            $.ajax({
                type: 'DELETE',
                url: "{{ url('/') }}" + "/api/appliances/" + id,
                contentType: "application/json; charset=utf-8",
                dataType: 'JSON'
            }).done(function() {
                Swal.fire({
                    title: "Sucesso",
                    text: "Eletrodoméstico excluído com sucesso",
                    type: "success",
                    showConfirmButton: false,
                    timer: 2000
                });
                $("#appliances").DataTable().ajax.reload();
            }).fail(function(jqXHR, textStatus, msg){
                Swal.fire({
                    title: "Erro",
                    text: jqXHR.responseJSON.message,
                    type: "error",
                    showConfirmButton: true,
                });
            });
        }

        $("#adicionar").click(function (){
            var array = {
                "name": $("#name").val(),
                "description": $("#description").val(),
                "voltage": $("#voltage").val(),
                "mark_id": 1
            };
            var data = JSON.stringify(array);

            $.ajax({
                type: 'POST',
                url: "{{ url('/') }}" + "/api/appliances",
                contentType: "application/json; charset=utf-8",
                data: data,
                dataType: 'JSON'
            }).done(function() {
                Swal.fire({
                    title: "Sucesso",
                    text: "Eletrodoméstico criado com sucesso",
                    type: "success",
                    showConfirmButton: false,
                    timer: 2000
                });
                $("#appliances").DataTable().ajax.reload();
            }).fail(function(jqXHR, textStatus, msg){
                Swal.fire({
                    title: "Erro",
                    text: jqXHR.responseJSON.message,
                    type: "error",
                    showConfirmButton: true,
                });
            });

            $("#staticBackdrop").modal('hide');
            clearFields();
        });

        $("#update").click(function (){
            var array = {
                "name": $("#name").val(),
                "description": $("#description").val(),
                "voltage": $("#voltage").val(),
                "mark_id": 1
            };
            var data = JSON.stringify(array);

            $.ajax({
                type: 'PUT',
                url: "{{ url('/') }}" + "/api/appliances/" + $("#id").val(),
                contentType: "application/json; charset=utf-8",
                data: data,
                dataType: 'JSON'
            }).done(function() {
                Swal.fire({
                    title: "Sucesso",
                    text: "Eletrodoméstico atualizado com sucesso",
                    type: "success",
                    showConfirmButton: false,
                    timer: 2000
                });
                $("#appliances").DataTable().ajax.reload();
            }).fail(function(jqXHR, textStatus, msg){
                Swal.fire({
                    title: "Erro",
                    text: jqXHR.responseJSON.message,
                    type: "error",
                    showConfirmButton: true,
                });
            });

            $("#titleModal").text('Adicionar');
            $("#update").hide();
            $("#adicionar").show();
            $("#staticBackdrop").modal('hide');
            clearFields();
        });

        $columns = [
            { "data": "id" },
            { "data": "name" },
            { "data": "description" },
            { "data": "voltage" },
            {
                "render": function (data, type, row, meta) {
                    return '<a onclick="editAppliance('+row.id+')" class="btn btn-sm btn-secondary mr-1" href="#"><i class="fas fa-edit"></i></a>' +
                        '<a onclick="deleteAppliance('+row.id+')" class="btn btn-sm btn-danger" href="#"><i class="fas fa-trash"></i></a>';
                }
            }
        ];

        $("#appliances").DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('/') }}" + "/api/appliances",
                "dataType": "json",
                "type": "GET",
            },
            "columns": $columns,
            dom: 'Bfrtip',
            "paging": true,
            "pageLength": 15,
            "lengthChange": true,
            "ordering": true,
            "order": [0, 'desc'],
            "info": true,
            "autoWidth": true,
            "responsive": true
        });
    </script>
@endsection
