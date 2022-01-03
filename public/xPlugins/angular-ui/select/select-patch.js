angular.module('ui.select')
.config(['$provide',
	function ($provide) {
		var uiSelectPatchDelegate = function ($delegate) {
			var directive = $delegate[0],
				origLink = directive.link,
				newLink = function (scope, element, attrs, ctrls, transcludeFn) {
					var _searchInput = element.querySelectorAll('input.ui-select-search'),
						$select = ctrls[0];

					// Add highlighted item on blur
					_searchInput.on('blur', function () {
						scope.$evalAsync(function () {
							//if ($select.search) {
							$select.select($select.items[$select.activeIndex]);
							//}
						});
					});

					// Patch that prevents error when we add a new tag by clicking 'enter'
					var originalSelectFuncRef = $select.select;
					$select.select = function () {
						// If 'null' set to 'undefined'
						if (!arguments[0]) {
							arguments[0] = undefined;
							console.log("select2 patch - item was null!, setting to undefined");
						}
						// Call original select func
						originalSelectFuncRef.apply(this, arguments);
					};

					// Now that we've run our code, call the original link function
					origLink.apply(this, arguments);
				};

			// GF - update the old link function with our new one
			directive.compile = function compile(tElement, tAttrs) {
				return {
					post: newLink
				}
			};

			return $delegate;
		};

		$provide.decorator("uiSelectDirective", ['$delegate', uiSelectPatchDelegate]);
	}
]);