<style>
    .content h1 {
        text-align: center;
    }
    .content .content-footer p {
        color: #6d6d6d;
        font-size: 12px;
        text-align: center;
    }
    .content .content-footer p a {
        color: inherit;
        font-weight: bold;
    }

    /*	--------------------------------------------------
        :: Table Filter
        -------------------------------------------------- */
    .panel {
        border: 1px solid #ddd;
        background-color: #fcfcfc;
    }
    .panel .btn-group {
        margin: 15px 0 30px;
    }
    .panel .btn-group .btn {
        transition: background-color .3s ease;
    }
    .table-filter {
        background-color: #fff;
        border-bottom: 1px solid #eee;
    }
    .table-filter tbody tr:hover {
        cursor: pointer;
        background-color: #eee;
    }
    .table-filter tbody tr td {
        padding: 10px;
        vertical-align: middle;
        border-top-color: #eee;
    }
    .table-filter tbody tr.selected td {
        background-color: #eee;
    }
    .table-filter tr td:first-child {
        width: 38px;
    }
    .table-filter tr td:nth-child(2) {
        width: 35px;
    }
    .ckbox {
        position: relative;
    }
    .ckbox input[type="checkbox"] {
        opacity: 0;
    }
    .ckbox label {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .ckbox label:before {
        content: '';
        top: 1px;
        left: 0;
        width: 18px;
        height: 18px;
        display: block;
        position: absolute;
        border-radius: 2px;
        border: 1px solid #bbb;
        background-color: #fff;
    }
    .ckbox input[type="checkbox"]:checked + label:before {
        border-color: #2BBCDE;
        background-color: #2BBCDE;
    }
    .ckbox input[type="checkbox"]:checked + label:after {
        top: 3px;
        left: 3.5px;
        content: '\e013';
        color: #fff;
        font-size: 11px;
        font-family: 'Glyphicons Halflings';
        position: absolute;
    }
    .table-filter .star {
        color: #ccc;
        text-align: center;
        display: block;
    }
    .table-filter .star.star-checked {
        color: #F0AD4E;
    }
    .table-filter .star:hover {
        color: #ccc;
    }
    .table-filter .star.star-checked:hover {
        color: #F0AD4E;
    }
    .table-filter .media-photo {
        width: 40px;
        height: 40px;
    }
    .table-filter .media-body {
        display: block;
        /* Had to use this style to force the div to expand (wasn't necessary with my bootstrap version 3.3.6) */
    }
    .table-filter .media-meta {
        font-size: 11px;
        color: #999;
    }
    .table-filter .media .title {
        color: #2BBCDE;
        font-size: 14px;
        font-weight: bold;
        line-height: normal;
        margin: 0;
    }
    .table-filter .media .title span {
        font-size: .8em;
        margin-right: 20px;
    }
    .table-filter .media .title span.pagado {
        color: #5cb85c;
    }
    .table-filter .media .title span.pendiente {
        color: #f0ad4e;
    }
    .table-filter .media .title span.cancelado {
        color: #d9534f;
    }
    .table-filter .media .summary {
        font-size: 14px;
    }
</style>

<div class="container col-md-12" id="viewGarageDetailFieldResponsed">
    <div class="row">
        <div class="card hovercard">
            <div class="cardheader" style="height: 50px !important;" align="right">
                <div id="actionBar">
                    <a id="closeGaragesListBtn" href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true" style="font-size:30px; color: #fbab56"></i></a>
                </div>
            </div>
            <div class="table-container" align="left">
                <table class="table table-filter table-responsive">
                    <tbody id="garagesListField">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
