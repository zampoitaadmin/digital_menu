
{{--<div class="col-lg-2 col-md-12 right-box">--}}
    <div class="card bg-transparent d-sm-none d-md-block d-none d-sm-block">
        <div class="body widget text-center py-1 px-1 ">
            <span class="loaderCategory" ng-bind-html="loaderUserSelectedCategory" ng-if="loaderUserSelectedCategory.length>0"></span>
            <ul ui-sortable="sortableOptions" ng-model="userSelectedCategories" class="list-unstyled categories-clouds mb-0 list" ng-if="userSelectedCategories.length>0">
                <li class="w-100 item" ng-repeat="category in userSelectedCategories">
                    <a href="javascript:void(0);" class="btn_custom_for_only_color">@{{ category.name }}</a>
                </li>
            </ul>
        </div>
    </div>
    {{--<div class="justify-content-center d-flex m-4 d-block d-sm-none">
        <button type="button" class="btn btn_custom_for_only_color" data-toggle="modal" data-target="#exampleModal">
            Select Your Category
        </button>
    </div>--}}
{{--</div>--}}
