(function($) {
    "use strict";

    var Cart = function()
    {
        this.$el = $('body');
        this.listen();
    };

    Cart.prototype = {
        listen: function()
        {
            var self = this;

            self.$el.on('blur', 'input.qty', function(e) {
                self.fixQuantity($(this));
            });

            $('form.msi_store_detail_new').on('submit', function(e) {
                self.addElement($(this));
                e.preventDefault();
            });

            $('form.msi_store_detail_edit').on('blur', 'input', function(e) {
                self.editElement($(this));
            });

            $('form.msi_store_detail_edit').on('submit', function(e) {
                self.editElement($(this).find('input'));
                e.preventDefault();
            });

            self.$el.on('click', 'a.msi_store_detail_delete', function(e) {
                self.removeElement($(this));
                e.preventDefault();
            });

            $('a.increment').on('click', function(e) {
                self.increment($(this));
                e.preventDefault();
            });

            $('a.decrement').on('click', function(e) {
                self.decrement($(this));
                e.preventDefault();
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
                    $('.cart-count').text(data.count);
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
                    $('.cart-count').text(data.count);
                    $('.detailTotal'+data.id).html('$'+data.detailTotal);
                    $('.orderSubtotal').html('$'+data.subtotal);
                    $('.orderPst').html('$'+data.pst);
                    $('.orderGst').html('$'+data.gst);
                    $('.orderTotal').html('$'+data.total);
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
                    $('.cart-count').text(data.count);
                    $('.orderSubtotal').html('$'+data.subtotal);
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
