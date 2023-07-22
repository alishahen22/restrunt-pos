@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row" id="getTables">

    </div>
    <div class="row   justify-content-center">
        <div class="col-5">
            <button class="btn btn-primary w-100" type="button" id="button-show-tables">View All Tables</button>
            <div class="menu-table my-3"></div>
            <div style="height: 120px" class="menu-order my-3"></div>

        </div>
        <div class="col-7">
            <ul class="nav nav-tabs">
                @foreach ($categories as $category)
                <li class="nav-item">
                    <a class="nav-link text-dark category" date-id='{{ $category->id }}' >{{ $category->name }}</a>
                  </li>
                @endforeach
              </ul>
              <div class="menu"> </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->


  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h3 id="totalAmount"></h3>
          <div class="d-flex ">
            <input class="form-control  " id ='recieve' type="number">
        </div>

        <h3 class="my-3"  id="change"></h3>
       <select class="form-select form-select mb-3" id="payment_type" aria-label=".form-select-lg example">
            <option value="cash">Cash</option>
            <option value="credit">Credit Card</option>
            </select>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id='save-payment' disabled>Save changes</button>
        </div>
      </div>
    </div>
  </div>
    <script>
    $(document).ready(function(){
        //make table hidden by default
        $('#getTables').hide();

        //show table when user click on button
        $('#button-show-tables').click(function(){
        if ($('#getTables').is(':hidden')) {

            $.ajax({
                url: "{{ route('cachier.gettable') }}",
                method: "GET",
                success: function(data){
                    $('#getTables').html(data);
                    $('#getTables').slideDown('fast');
                    $('#button-show-tables').html('Hide All Tables').removeClass('btn-primary').addClass('btn-danger');
                }
            })

        }else{
            $('#getTables').slideUp('fast');
            $('#button-show-tables').html('View All Tables').removeClass('btn-danger').addClass('btn-primary');
        }
        });

        //show menu when user click on category
        $('.category').click(function () {
            $.ajax({
                url: '/cachier/getmenu/'+$(this).attr('date-id'),
                method: "GET",
                success: function(data){
                    $('.menu').html(data);
                }
            })
        })

        var TABLE_ID = '';
        // selected table
        $(document).on('click', '.table-btn', function(){
               TABLE_ID =  $(this).attr('data-id');
           $('.menu-table').html('<h3>Table Number : '+$(this).attr('data-name')+'</h3> <hr>');
           $.ajax({
                url: '/cachier/getOrderByTable/'+$(this).attr('data-id'),
                method: "get",
                success: function(data){
                    $('.menu-order').html(data);
                } ,


        });
    });

        //select Menu
        $(document).on('click', '.order', function(){
            if (TABLE_ID == '') {
                alert('Please Select Table First');
            }else{
                $.ajax({
                url: '/cachier/saveorder',
                method: "POST",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'table_id':TABLE_ID,
                    'menu_id': $(this).attr('data-id'),
                    'quantity': 1
                },
                success: function(data){
                    $('.menu-order').html(data);
                }
            })
            }

        });


        $(document).on('click', '.confirm-btn', function(){
            $.ajax({
                url: '/cachier/confirmorder',
                method: "POST",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'sale_id': $(this).attr('data-id'),
                },
                success: function(data){
                    $('.menu-order').html(data);
                }
            })
        });


        $(document).on('click', '.trath-btn', function(){
            $.ajax({
            url: '/cachier/deletemenu',
            method: "Post",
            data: {
                '_token': "{{ csrf_token() }}",
                'sale_detail': $(this).attr('data-id'),
            },
            success: function(data){
                $('.menu-order').html(data);
            }
        })
        });
        var sale_id = '';
        var total_amount=0;
        $(document).on('click', '.payment-btn', function(){
            sale_id = $(this).attr('data-id');
             total_amount = $(this).attr('data-amount');
            $(' #totalAmount').html('Total Amount To Be Paid :<span class = "fw-bold" id="amount" data-amount="'+ total_amount+'"> $'+$(this).attr('data-amount')+'</span>');
            $('#recieve').val('');
            $('#change').html('');

        });

        $( "#recieve" ).keyup(function() {
           var total =  ( $(this).val() - total_amount  ) ;
           if (total < 0 ) {
            $(' #save-payment').prop( "disabled", true );
               }else
               {
                $('#save-payment').prop("disabled", false);
               }

             $('#change').html(' Total change $'+total);

            });


            $(document).on('click', '#save-payment', function(){
          var   total_recieve= $( '#recieve' ).val();
          var   payment_type = $('#payment_type').val();
          $.ajax({
            url: '/cachier/savepayment',
            method: "Post",
            data: {
                '_token': "{{ csrf_token() }}",
                'total_recieved':total_recieve,
                'payment_type':payment_type,
                'sale_id':sale_id,
                'total_price':total_amount
            },
            success: function(data){


               window.location.href= data;

            },



        })
        });

    });
</script>
@endsection

