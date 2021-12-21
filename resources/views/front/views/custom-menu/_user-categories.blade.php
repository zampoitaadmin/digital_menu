<div class="ud-single-feature wow fadeInUp" data-wow-delay=".15s" style="visibility: visible; animation-delay: 0.15s; animation-name: fadeInUp;">
    <div class="ud-feature-content">
        <h3 class="ud-feature-title"><b>@{{ userCategories.length }}</b> Your Selected category.</h3>
        <p class="ud-feature-desc">
        <ul ng-if="userCategories.length>0">
            <li ng-repeat="category in userCategories">
                <b>@{{ category.name }}</b>

            </li>
        </ul>
        </p>
    </div>
</div>