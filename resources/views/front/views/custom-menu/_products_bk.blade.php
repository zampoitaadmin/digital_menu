<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="ud-section-title mx-auto text-center">
                <p>
                    This is Product Page @{{status}}
                </p>


            </div>
        </div>
    </div>
</div>



@section('script')
    {{--<script type='text/javascript' src='{{ asset("assets/ng/sso/index.js".'?t='.time()) }}'></script>--}}
    {{--<script type='text/javascript' src='{{ asset(
    "assets/ng/sso/MainController.js".'?t='.time()) }}'></script>--}}
    <script src='{{ asset("assets/ng/products/CustomMenuProductController.js".'?t='.time()) }}'></script>
@endsection