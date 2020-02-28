define([
    "jquery",
    "jquery/ui",
    'underscore'
], function ($, ui, _) {

    $.widget('mage.ghosterRenerQuickViewButton', {
        options: {},
        textElement: null,
        parent: null,

        _create: function () {
            this.element = $(this.element);
            if (this.element.attr('ghoster-quickview-js-observed')) {
                return;
            }
            this.element.attr('ghoster-quickview-js-observed', 1);

            var items = this.element.parent().find(this.getPriceSelector());
            if (items.length) {
                var priceContainer = items.first(),
                    newParent = this.getNewParent(priceContainer);

                if (newParent && newParent.length) {
                    priceContainer.attr('label-observered-' + this.options.label, '1');
                    newParent.append(this.element);
                } else {
                    this.element.hide();
                    return;
                }
            } else {
                this.element.hide();
                return;
            }

            this.textElement = this.element.find('.ghoster-quickview-text');
            this.parent = this.element.parent();

            if (this.options.path && this.options.path != "") {
                var newParent = this.parent.find(this.options.path);
                if (newParent.length) {
                    this.parent = newParent;
                    newParent.append(this.element);
                }
            }

            if (!(this.parent.css('position') == 'absolute' || this.parent.css('position') == 'relative')) {
                this.parent.css('position', 'relative');
            }

            if (this.parent.prop("tagName") == "A") {
                this.parent.css('display', 'block');
            }

            $('.product-item-info').css('zIndex', '2000');


            this.setButtonPosition();
            this.setButtonStyle();
            this.createResizeEvent();
        },

        createResizeEvent: function () {
            $(window).on('resize', _.debounce(function () {
                this.reloadParentSize();
            }.bind(this), 300));

            $(window).on('orientationchange', function () {
                this.reloadParentSize();
            }.bind(this));
        },


        setStyleIfNotExist: function (element, styles) {
            for (style in styles) {
                var current = element.attr('style');
                if (!current ||
                    (current.indexOf('; ' + style) == -1 && current.indexOf(';' + style) == -1)
                ) {
                    element.css(style, styles[style]);
                }
            }

        },

        setButtonStyle: function () {
            var display = this.options.alignment === '1' ? 'inline-block' : 'block';

            /** Tex Element **/
            this.setStyleIfNotExist(
                this.textElement,
                {
                    'padding': '0 3px',
                    'position': 'absolute',
                    'box-sizing': 'border-box',
                    'white-space': 'nowrap',
                    'width': '100%'
                }
            );

            this.element.parent().css({
                'line-height': 'normal',
                'position': 'absolute',
                'z-index': 995
            });

            this.setStyleIfNotExist(
                this.element,
                {
                    'position': 'relative',
                    'display': display
                }
            );

            this.element.click(function () {
                $(this).parent().trigger('click');
            });

            this.reloadParentSize();
        },

        setPosition: function (position) {
            this.options.position = position;
            this.setButtonPosition();
            this.reloadParentSize();
        },

        setStyle: function () {
            this.setButtonStyle();
        },

        reloadParentSize: function () {
            var parent = this.element.parent(),
                height = null,
                width = 5;

            parent.css({
                'position': 'relative',
                'display': 'inline-block',
                'width': 'auto',
                'height': 'auto'
            });
            height = parent.height();

            if (this.options.alignment === '1') {
                parent.children().each(function (index, element) {
                    width += $(element).width() + parseInt($(element).css('margin-left'))
                        + parseInt($(element).css('margin-right'));
                });
            } else {
                width = parent.width();
            }

            parent.css({
                'position': 'absolute',
                'display': 'block',
                'height': height ? height + 'px' : '',
                'width': width ? width + 'px' : ''
            });
        },

        getWidgetQuickViewCode: function () {
            var label = '';
            if (this.element.parents('.widget-product-grid, .widget').length) {
                label = 'widget';
            }

            return label;
        },

        setButtonPosition: function () {
            var className = 'ghoster-quickview-position-' + this.options.position
                + '-' + this.options.product + '-' + this.options.mode + this.getWidgetQuickViewCode(),
                wrapper = this.parent.find('.' + className);

            if (wrapper.length) {
                wrapper.append(this.element);

                if (this.options.alignment === '1') {
                    this.setStyleIfNotExist(
                        this.element,
                        {
                            'marginLeft': this.options.margin + 'px'
                        }
                    );
                } else {
                    this.setStyleIfNotExist(
                        this.element,
                        {
                            'marginTop': this.options.margin + 'px'
                        }
                    );
                }
            } else {
                var parent = this.element.parent();
                if (parent.hasClass('ghoster-quickview-position-wrapper')) {
                    parent.parent().append(this.element);
                }

                this.element.wrap("<div class='" + className + ' ghoster-quickview-position-wrapper' + "'></div>");
                wrapper = this.element.parent();
            }

            wrapper.css({
                'top': "",
                'left': "",
                'right': "",
                'bottom': "",
                'margin-top': "",
                'margin-bottom': "",
                'margin-left': "",
                'margin-right': ""
            });

            switch (this.options.position) {
                case 'top-left':
                    wrapper.css({
                        'top': 0,
                        'left': 0
                    });
                    break;
                case 'top-center':
                    wrapper.css({
                        'top': 0,
                        'left': 0,
                        'right': 0,
                        'margin-left': 'auto',
                        'margin-right': 'auto'
                    });
                    break;
                case 'top-right':
                    wrapper.css({
                        'top': 0,
                        'right': 0,
                        'text-align': 'right'
                    });
                    break;

                case 'middle-left':
                    wrapper.css({
                        'left': 0,
                        'top': 0,
                        'bottom': 0,
                        'margin-top': 'auto',
                        'margin-bottom': 'auto'
                    });
                    break;
                case 'middle-center':
                    wrapper.css({
                        'top': 0,
                        'bottom': 0,
                        'margin-top': 'auto',
                        'margin-bottom': 'auto',
                        'left': 0,
                        'right': 0,
                        'margin-left': 'auto',
                        'margin-right': 'auto'
                    });
                    break;
                case 'middle-right':
                    wrapper.css({
                        'top': 0,
                        'bottom': 0,
                        'margin-top': 'auto',
                        'margin-bottom': 'auto',
                        'right': 0,
                        'text-align': 'right'
                    });
                    break;

                case 'bottom-left':
                    wrapper.css({
                        'bottom': 0,
                        'left': 0
                    });
                    break;
                case 'bottom-center':
                    wrapper.css({
                        'bottom': 0,
                        'left': 0,
                        'right': 0,
                        'margin-left': 'auto',
                        'margin-right': 'auto'
                    });
                    break;
                case 'bottom-right':
                    wrapper.css({
                        'bottom': 0,
                        'right': 0,
                        'text-align': 'right'
                    });
                    break;
            }
        },

        getNewParent: function (item) {
            var boxContainer = null,
                productContainer = item.parents('.item').first();

            if (!productContainer.length) {
                productContainer = item.parents('.product-item');
            }

            if (productContainer && productContainer.length) {
                boxContainer = productContainer.find(this.options.path).first();
            }

            return boxContainer;
        },

        getPriceSelector: function () {
            var notLabelObservered = ':not([label-observered-' + this.options.label + '])',
                selector = '[data-product-id="' + this.options.product + '"]' + notLabelObservered + ', ' +
                    '[id="product-price-' + this.options.product + '"]' + notLabelObservered + ', ' +
                    '[name="product"][value="' + this.options.product + '"]' + notLabelObservered;

            return selector;
        }
    });

    return $.mage.ghosterRenerQuickViewButton;
});
