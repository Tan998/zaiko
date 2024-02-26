<?php if (!defined('IN_SITE')) die ('The request not found'); ?>
    <style>
        footer {
            display: flex;
            height: 26px;
            align-items: center;
            justify-content: center;
            color: chocolate;
            background-color: antiquewhite;
            }
    </style>

            <footer class=" col-12 footer fixed-bottom">copy right by homebear 2023</footer>
            </div>
        </div>


    
                <script>
                //datatble custom
                $(document).ready(function () {
                  
                $('.dataTables_filter input[type="search"]').attr("placeholder", "商品を探す");
                  //$('.dataTables_filter label').text("aaaa");
                });
                if(document.querySelector('table')) {
                    $('table.table').DataTable( {
                        language: {
                            search: '<i class="bi bi-search"></i>',
                            zeroRecords:    "データ無し",
                            emptyTable:     "データ無し",
                            lengthMenu:    "表示 _MENU_ 件",
                            info:           "検索結果 _TOTAL_ のうち _START_ - _END_ 件",
                            infoEmpty:      "検索結果 0 のうち 0 - 0 件",
                            infoFiltered:   "(合計 _MAX_ 件からフィルタリング)",
                            paginate: {
                                first:      "最初",
                                previous:   "前へ",
                                next:       "次へ",
                                last:       "最後"
                                },
                        },
                        'order' :[],
                        responsive: true,
                    });
                }
                //検索結果 482 のうち 1-48件 合計 23 のエントリからフィルタリング
                </script>
                <script>
                    //auto scroll top
                    document.querySelectorAll("#scroll_navheader").forEach(function (a) {
                    a.addEventListener("click", function (event) {
                      event.preventDefault();
                      const hash = event.target.getAttribute("href");
                      const scrollTarget = document.querySelector(hash);
                      
                      // Some additional logic
                      //const headerHeight = 90;
                      window.scrollTo(0, scrollTarget); //, scrollTarget.offsetTop - headerHeight
                    });
                  });
                </script>
                <script>
                    //popup
                    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                        return new bootstrap.Popover(popoverTriggerEl)
                    })
                </script>

    </body>
</html>

<?php 
/*
$('#example').DataTable( {
    language: {
        processing:     "Traitement en cours...",
        search:         "Rechercher&nbsp;:",
        lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
        info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        infoPostFix:    "",
        loadingRecords: "Chargement en cours...",
        zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        emptyTable:     "Aucune donnée disponible dans le tableau",
        paginate: {
            first:      "Premier",
            previous:   "Pr&eacute;c&eacute;dent",
            next:       "Suivant",
            last:       "Dernier"
        },
        aria: {
            sortAscending:  ": activer pour trier la colonne par ordre croissant",
            sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
    }
} );
*/
 ?>