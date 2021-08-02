<div class="modal fade" id="showSpecialAction" tabindex="-1" role="dialog" aria-labelledby="showSpecialActionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <img src="/images/royal_reward.jpg">
            </div>
            <button type="button" class="btn-main btn-main-out" data-dismiss="modal">Закрыть</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        $(document).ready(function () {
            let check = Cookies.get('is_show_showSpecialAction');
            if (check !== 'Y') {
                setTimeout(function () {
                    $('#showSpecialAction').modal('show');
                }, 3500);
            }
        });

        $('#showSpecialAction').on('hidden.bs.modal', function () {
            Cookies.set('is_show_showSpecialAction', 'Y');
        })
    });
</script>

<style>
    #showSpecialAction .modal-content {
        position: relative;
    }

    #showSpecialAction .btn-main {
        font-size: 18px;
        border-radius: 0;
    }

    #showSpecialAction .close {
        position: absolute;
        top: -10px;
        right: -10px;
    }
</style>