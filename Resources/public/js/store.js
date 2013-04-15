(function($) {
    "use strict";

    var Cart = function()
    {
        this.$el = $('body');
        this.loadingCellIds = [];

        this.listen();
    };

    Cart.prototype = {
        listen: function()
        {
            var self = this;

            $('form.form-limit').on('change', 'select', function() {
                $(this).closest('form').submit();
            });

            $('form.form-sort').on('change', 'select', function() {
                $(this).closest('form').submit();
            });

            self.$el.on('blur', 'input.qty', function(e) {
                self.fixQuantity($(this));
            });

            $('form.msi_store_detail_new').on('submit', function(e) {
                if (self.fixQuantity($(this).find('input.qty')) !== 0) {
                    self.addElement($(this));
                }
                e.preventDefault();
            });

            self.$el.on('blur', 'input.msi_store_cart_edit', function(e) {
                self.editElement($(this));
            });

            self.$el.on('click', 'a.cao_app_order_detail_delete', function(e) {
                self.removeElement($(this));
                e.preventDefault();
            });

            $('a.increment').on('click', function(e) {
                self.increment($(this));
                e.preventDefault();
            });

            self.$el.on('click', 'a.cao_app_wish_list_toggle', function(e) {
                self.wishListToggle($(this));
                e.preventDefault();
            });

            $('a.decrement').on('click', function(e) {
                self.decrement($(this));
                e.preventDefault();
            });

            $('div.alert').on('click', 'button.close', function(e) {
                $('div.alert').fadeOut(200);
                e.preventDefault();
            });
        },

        wishListToggle: function($btn)
        {
            var self = this,
                btnId = $btn.attr('id');

            if ($.inArray(btnId, self.loadingCellIds) !== -1) {
                return;
            }
            self.loadingCellIds.push(btnId);

            var isWishList = $btn.parent().parent().parent().hasClass('wish-list-tr');

            if (isWishList) {
                $btn.parent().parent().parent().addClass('error');
            }

            $btn.children('span').children().html('<img src="/bundles/msicmf/img/ajax-loader2.gif" alt="0">');

            $.ajax($btn.attr('href'), {
                success: function() {
                    if (isWishList) {
                        $btn.parent().parent().parent().fadeOut(200);
                    } else {
                        if ($btn.children('span').hasClass('badge-important')) {
                            var i = '<i class="icon-star icon-white"><span class="hide">0</span></i>';
                            $btn.children('span')
                                .removeClass('badge-important')
                                .children()
                                .empty()
                                .html(i)
                            ;
                        } else {
                            var i = '<i class="icon-star icon-white"><span class="hide">1</span></i>';
                            $btn.children('span')
                                .addClass('badge-important')
                                .children()
                                .empty()
                                .html(i)
                            ;
                        }
                    }

                    self.loadingCellIds.splice(self.loadingCellIds.indexOf(btnId), 1);
                }
            });
        },

        addElement: function($form)
        {
            var self = this;

            self.showAjaxLoader();

            $.ajax($form.attr('action'), {
                data: $form.serialize(),
                type: 'POST',
                success: function(data) {
                    $('#cart-count').text(data.count);
                    $('.alert').children('div').html(data.flash);
                    $('.alert').fadeIn(200);
                    $form.find('input.qty').val(0);
                }
            });
        },

        editElement: function($this)
        {
            var self = this;

            if (self.cleanNumber($this.val()) === 0) {
                self.removeElement($this.closest('tr').find('a.action-remove'));
                return;
            }

            self.showAjaxLoader();
            $.ajax($this.closest('form').attr('action'), {
                data: $this.closest('form').serialize(),
                type: 'POST',
                success: function(data) {
                    $('#cart-count').text(data.count);
                    $('#detailTotal'+data.id).html('$'+data.detailTotal);
                    $('#orderSubTotal').html('$'+data.subTotal);
                }
            });
        },

        removeElement: function($this)
        {
            var self = this;

            $this.closest('tr').addClass('error');
            self.showAjaxLoader();

            $.ajax($this.attr('href'), {
                success: function(data) {
                    $this.closest('tr').fadeOut(200);
                    $('#cart-count').text(data.count);
                    $('#orderSubTotal').html('$'+data.subTotal);
                }
            });
        },

        increment: function($this)
        {
            var $input = $this.siblings('input.qty');

            if ($input.val() >= 999) return;

            $input.val(this.cleanNumber($input.val()) + 1);
        },

        decrement: function($this)
        {
            var $input = $this.siblings('input.qty');

            if ($input.val() <= 1) return;

            $input.val(this.cleanNumber($input.val()) - 1);
        },

        showAjaxLoader: function() {
            this.$el.find('img.ajax-loader').removeClass('hide');
        },

        fixQuantity: function($input) {
            var val = this.cleanNumber($input.val());

            if (val < 1) {
                val = 0;
            }

            if (val > 999) {
                val = 999;
            }

            $input.val(val);

            return val;
        },

        cleanNumber: function(val) {
            val = Math.round(parseInt(val, 10));
            if (isNaN(val)) {
                return 0;
            } else {
                return val;
            }
        }
    };

    var cart = new Cart();
})(jQuery);
