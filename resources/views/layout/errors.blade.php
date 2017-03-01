@if ($errors->any())
    <div class="row">
        <div class="col-12">
            <ul class="errors">
                @foreach ($errors->all() as $error)
                    <li class="error"><i class="typcn typcn-warning"></i> {{ $error }}</li>
                    <!-- /.error -->
                @endforeach
            </ul>
            <!-- /.errors -->
        </div>
        <!-- /.col-12 -->
    </div>
    <!-- /.row -->
@endif
