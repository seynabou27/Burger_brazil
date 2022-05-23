
    // // lorsqu'on clique sur le "+" du panier
    // $('.qt-plus').on('click', function() {
    //     var $this = $(this);

    //     // récupère la quantité actuelle et l'id de l'article
    //     var qt = parseInt($this.prevAll('.qt').html());
    //     var id = $this.parent().parent().attr('data-id');
    //     var artWeight = parseInt($this.parent().parent().attr('data-weight'));

    //     // met à jour la quantité et le poids
    //     inCartItemsNum += 1;
    //     weight += artWeight;
    //     $this.prevAll('.qt').html(qt + 1);
    //     $('#in-cart-items-num').html(inCartItemsNum);
    //     $('#'+ id + ' .qt').html(qt + 1);

    //     // met à jour cartArticles
    //     cartArticles.forEach(function(v) {
    //         // on incrémente la qt
    //         if (v.id == id) {
    //             v.qt += 1;

    //             // récupération du prix
    //             // on effectue tous les calculs sur des entiers
    //             subTotal = ((subTotal * 1000) + (parseFloat(v.price.replace(',', '.')) * 1000)) / 1000;
    //         }
    //     });

    //     // met à jour la quantité du widget et sauvegarde le panier
    //     $('.subtotal').html(subTotal.toFixed(2).replace('.', ','));
    //     saveCart(inCartItemsNum, cartArticles);
    // });

    // // quantité -
    // $('.qt-minus').click(function() {
    //     var $this = $(this);
    //     var qt = parseInt($this.prevAll('.qt').html());
    //     var id = $this.parent().parent().attr('data-id');
    //     var artWeight = parseInt($this.parent().parent().attr('data-weight'));

    //     if (qt > 1) {
    //         // maj qt
    //         inCartItemsNum -= 1;
    //         weight -= artWeight;
    //         $this.prevAll('.qt').html(qt - 1);
    //         $('#in-cart-items-num').html(inCartItemsNum);
    //         $('#'+ id + ' .qt').html(qt - 1);

    //         cartArticles.forEach(function(v) {
    //             // on décrémente la qt
    //             if (v.id == id) {
    //                 v.qt -= 1;

    //                 // récupération du prix
    //                 // on effectue tous les calculs sur des entiers
    //                 subTotal = ((subTotal * 1000) - (parseFloat(v.price.replace(',', '.')) * 1000)) / 1000;
    //             }
    //         });

    //         $('.subtotal').html(subTotal.toFixed(2).replace('.', ','));
    //         saveCart(inCartItemsNum, cartArticles);
    //     }
    // });

    alert(ok);