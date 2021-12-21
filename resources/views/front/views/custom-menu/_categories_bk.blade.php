<div class="container" ng-cloak>
    <div class="row">
        <div class="col-md-12">
            <div class="ud-section-title mx-auto text-center">
                <p>
                    This is Category Page @{{ isLogged  }}
                </p>
                <h3 ng-bind-html="message"></h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-sm-6">
            <div class="ud-single-feature wow fadeInUp" data-wow-delay=".1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeInUp;">
                <div class="ud-feature-content">
                    <h3 class="ud-feature-title"><b>@{{ categories.length }}</b> All category. @{{ isLogged  }}</h3>
                    <p class="ud-feature-desc">
                        <ul ng-if="categories.length>0">
                            <li ng-repeat="category in categories">
                                <b>@{{ category.name }}</b>
                                {{--<button ng-click="load(book.id)" class="btn btn-info btn-xs">Update</button>
                                <button ng-click="remove(book.id)" class="btn btn-danger btn-xs">Remove</button>--}}
                            </li>
                        </ul>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-6">
            <div class="ud-single-feature wow fadeInUp" data-wow-delay=".15s" style="visibility: visible; animation-delay: 0.15s; animation-name: fadeInUp;">
                <div class="ud-feature-content">
                    <h3 class="ud-feature-title"><b>@{{ userCategories.length }}</b> Your category.</h3>
                    <p class="ud-feature-desc">
                    <ul ng-if="userCategories.length>0">
                        <li ng-repeat="category in userCategories">
                            <b>@{{ category.name }}</b>
                            {{--<button ng-click="load(book.id)" class="btn btn-info btn-xs">Update</button>
                            <button ng-click="remove(book.id)" class="btn btn-danger btn-xs">Remove</button>--}}
                        </li>
                    </ul>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-sm-6">
            <div class="ud-single-feature wow fadeInUp" data-wow-delay=".15s" style="visibility: visible; animation-delay: 0.15s; animation-name: fadeInUp;">
                <div class="ud-feature-content">
                    <h3 class="ud-feature-title"><b>@{{ userSelectedCategories.length }}</b> Your Selected category.</h3>
                    <p class="ud-feature-desc">
                    <ul ng-if="userCategories.length>0">
                        <li ng-repeat="category in userSelectedCategories">
                            <b>@{{ category.name }}</b>

                        </li>
                    </ul>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    {{--<script src='{{ asset("assets/ng/category/CustomMenuCategoryController.js".'?t='.time()) }}'></script>
    <script src='{{ asset("assets/ng/category/servicesCategory.js".'?t='.time()) }}'></script>--}}
@endsection