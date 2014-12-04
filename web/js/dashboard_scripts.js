/*
 * Scripts for "Dashboard" page
 */

$(document).ajaxStart(function() {
    $(".left-sidebar input:checkbox").prop("disabled", true);
});

$(document).ajaxStop(function() {
    $(".left-sidebar input:checkbox").prop("disabled", false);
});

$(document).ready(function() {
    var region_name = '';
    var region_name_us = '';



    function initMapPopupWindow(element) {
        $('.eurasia').hide();
        $('#vmap').hide();
        $('#vmap1').hide();


        var myPos = { my: "center top", at: "center top+20", of: window };

        $("." + element).dialog({
            autoOpen: false,
            height: 'auto',
            width: 815,
            modal: true,
            position:myPos,
            open: function() {
            },
            close: function() {
                $(this).dialog("close");
            }
        });
        $('.close_btn').on('click', function(){
            $("#" + element).dialog("close");
        });
    }
    initMapPopupWindow("dialog_for_map");

    $('#vmap1').vectorMap({
        map: 'usa_en',
        backgroundColor: null,
        color: '#57A0C1',
        hoverOpacity: 0.7,
        selectedColor: '#666666',
        enableZoom: true,
        showTooltip: true,
        selectedRegion: 'MO'
    });

    $('#vmap').vectorMap({
        map: 'world_en',
        backgroundColor: null,
        color: '#ffffff',
        hoverOpacity: 0.7,
        selectedColor: '#666666',
        enableZoom: true,
        showTooltip: true,
        values: sample_data,
        scaleColors: ['#57A0C1'],
        normalizeFunction: 'polynomial'
    });


    $('#jqvmap2_gl, #jqvmap2_pf, #jqvmap2_fk, #jqvmap2_cu, #jqvmap2_gf, #jqvmap2_so, #jqvmap2_tm, #jqvmap2_kp, #jqvmap2_re, #jqvmap2_nc').css({'fill': '#57A0C1'});


    $('.jsmapclick').click(function(){
        $('#vmap').show();
        $('#vmap1').hide();

        $('.dialog_for_map').dialog("open");

    });

    $('.jsmapclick_us').click(function(){
        $('#vmap1').show();
        $('#vmap').hide();

        $('.dialog_for_map').dialog("open");

    });

    //north america
    $('#jqvmap2_gl, #jqvmap2_ca, #jqvmap2_us, #jqvmap2_mx, #jqvmap2_gt, #jqvmap2_bz, #jqvmap2_sv, #jqvmap2_hn, #jqvmap2_ni, #jqvmap2_cr, #jqvmap2_pa, #jqvmap2_bs, #jqvmap2_jm, #jqvmap2_cu, #jqvmap2_ht, #jqvmap2_do, #jqvmap2_tt, #jqvmap2_gd, #jqvmap2_bb, #jqvmap2_lc, #jqvmap2_dm, #jqvmap2_ag, #jqvmap2_kn').click(function(){
        $('#jqvmap2_gl, #jqvmap2_ca, #jqvmap2_us, #jqvmap2_mx, #jqvmap2_gt, #jqvmap2_bz, #jqvmap2_sv, #jqvmap2_hn, #jqvmap2_ni, #jqvmap2_cr, #jqvmap2_pa, #jqvmap2_bs, #jqvmap2_jm, #jqvmap2_cu, #jqvmap2_ht, #jqvmap2_do, #jqvmap2_tt, #jqvmap2_gd, #jqvmap2_bb, #jqvmap2_lc, #jqvmap2_dm, #jqvmap2_ag, #jqvmap2_kn').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#ffa767"});

        $('.eurasia').hide();

        $('#jqvmap2_fk, #jqvmap2_co, #jqvmap2_ve, #jqvmap2_ec, #jqvmap2_gy, #jqvmap2_sr, #jqvmap2_gf, #jqvmap2_br, #jqvmap2_pe, #jqvmap2_bo, #jqvmap2_py, #jqvmap2_uy, #jqvmap2_ar, #jqvmap2_cl').css({"stroke":"#828282", "stroke-width": "2px", "fill": "#57A0C2"});
        $('#jqvmap2_km, #jqvmap2_sc, #jqvmap2_mu, #jqvmap2_re, #jqvmap2_eg, #jqvmap2_ly, #jqvmap2_tn, #jqvmap2_dz, #jqvmap2_ma, #jqvmap2_mr, #jqvmap2_ml, #jqvmap2_ne, #jqvmap2_td, #jqvmap2_sd, #jqvmap2_er, #jqvmap2_dj, #jqvmap2_so, #jqvmap2_et, #jqvmap2_ke, #jqvmap2_cf, #jqvmap2_cm, #jqvmap2_gq, #jqvmap2_st, #jqvmap2_ga, #jqvmap2_cg, #jqvmap2_ao, #jqvmap2_cd, #jqvmap2_rw, #jqvmap2_bi, #jqvmap2_tz, #jqvmap2_zm, #jqvmap2_zw, #jqvmap2_mw, #jqvmap2_mz, #jqvmap2_na, #jqvmap2_bw, #jqvmap2_za, #jqvmap2_ls, #jqvmap2_sz, #jqvmap2_mg, #jqvmap2_cv, #jqvmap2_gm, #jqvmap2_sn, #jqvmap2_gw, #jqvmap2_gn, #jqvmap2_sl, #jqvmap2_lr, #jqvmap2_ci, #jqvmap2_bf, #jqvmap2_gh, #jqvmap2_tg, #jqvmap2_bj, #jqvmap2_ng, #jqvmap2_ug').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2"});
        $('#jqvmap2_mv, #jqvmap2_is, #jqvmap2_no, #jqvmap2_ie, #jqvmap2_gb, #jqvmap2_se, #jqvmap2_fi, #jqvmap2_ee, #jqvmap2_lv, #jqvmap2_lt, #jqvmap2_by, #jqvmap2_ua, #jqvmap2_md, #jqvmap2_ro, #jqvmap2_hu, #jqvmap2_dk, #jqvmap2_de, #jqvmap2_nl, #jqvmap2_be, #jqvmap2_fr, #jqvmap2_it, #jqvmap2_es, #jqvmap2_pt, #jqvmap2_mt, #jqvmap2_cy, #jqvmap2_gr, #jqvmap2_tr, #jqvmap2_sy, #jqvmap2_sa, #jqvmap2_in, #jqvmap2_ru, #jqvmap2_pl, #jqvmap2_cz, #jqvmap2_sk, #jqvmap2_at #jqvmap2_ch, #jqvmap2_si, #jqvmap2_hr, #jqvmap2_ba, #jqvmap2_rs, #jqvmap2_bg, #jqvmap2_mk, #jqvmap2_al, #jqvmap2_lb, #jqvmap2_il, #jqvmap2_jo, #jqvmap2_iq, #jqvmap2_kw, #jqvmap2_qa, #jqvmap2_ae, #jqvmap2_om, #jqvmap2_ye, #jqvmap2_ir, #jqvmap2_ch, #jqvmap2_at, #jqvmap2_ge, #jqvmap2_am, #jqvmap2_az, #jqvmap2_kz, #jqvmap2_mn, #jqvmap2_cn, #jqvmap2_kp, #jqvmap2_kg, #jqvmap2_uz, #jqvmap2_tj, #jqvmap2_tm, #jqvmap2_af, #jqvmap2_pk, #jqvmap2_np, #jqvmap2_bt, #jqvmap2_bd, #jqvmap2_mm, #jqvmap2_th, #jqvmap2_jp, #jqvmap2_kr, #jqvmap2_tw, #jqvmap2_la, #jqvmap2_vn, #jqvmap2_kh, #jqvmap2_lk, #jqvmap2_id, #jqvmap2_my, #jqvmap2_bn, #jqvmap2_ph, #jqvmap2_tl').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2 "});
        $('#jqvmap2_au, #jqvmap2_pg, #jqvmap2_sb, #jqvmap2_vu, #jqvmap2_pf, #jqvmap2_fj, #jqvmap2_nc, #jqvmap2_nz').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2 "});

        region_name = "North America";
        $('.region_title p').html("North America");
    });

    //south america
    $('#jqvmap2_fk, #jqvmap2_co, #jqvmap2_ve, #jqvmap2_ec, #jqvmap2_gy, #jqvmap2_sr, #jqvmap2_gf, #jqvmap2_br, #jqvmap2_pe, #jqvmap2_bo, #jqvmap2_py, #jqvmap2_uy, #jqvmap2_ar, #jqvmap2_cl').click(function(){
        $('#jqvmap2_fk, #jqvmap2_co, #jqvmap2_ve, #jqvmap2_ec, #jqvmap2_gy, #jqvmap2_sr, #jqvmap2_gf, #jqvmap2_br, #jqvmap2_pe, #jqvmap2_bo, #jqvmap2_py, #jqvmap2_uy, #jqvmap2_ar, #jqvmap2_cl').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#ffa767"});

        $('.eurasia').hide();

        $('#jqvmap2_gl, #jqvmap2_ca, #jqvmap2_us, #jqvmap2_mx, #jqvmap2_gt, #jqvmap2_bz, #jqvmap2_sv, #jqvmap2_hn, #jqvmap2_ni, #jqvmap2_cr, #jqvmap2_pa, #jqvmap2_bs, #jqvmap2_jm, #jqvmap2_cu, #jqvmap2_ht, #jqvmap2_do, #jqvmap2_tt, #jqvmap2_gd, #jqvmap2_bb, #jqvmap2_lc, #jqvmap2_dm, #jqvmap2_ag, #jqvmap2_kn').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2"});
        $('#jqvmap2_km, #jqvmap2_sc, #jqvmap2_mu, #jqvmap2_re, #jqvmap2_eg, #jqvmap2_ly, #jqvmap2_tn, #jqvmap2_dz, #jqvmap2_ma, #jqvmap2_mr, #jqvmap2_ml, #jqvmap2_ne, #jqvmap2_td, #jqvmap2_sd, #jqvmap2_er, #jqvmap2_dj, #jqvmap2_so, #jqvmap2_et, #jqvmap2_ke, #jqvmap2_cf, #jqvmap2_cm, #jqvmap2_gq, #jqvmap2_st, #jqvmap2_ga, #jqvmap2_cg, #jqvmap2_ao, #jqvmap2_cd, #jqvmap2_rw, #jqvmap2_bi, #jqvmap2_tz, #jqvmap2_zm, #jqvmap2_zw, #jqvmap2_mw, #jqvmap2_mz, #jqvmap2_na, #jqvmap2_bw, #jqvmap2_za, #jqvmap2_ls, #jqvmap2_sz, #jqvmap2_mg, #jqvmap2_cv, #jqvmap2_gm, #jqvmap2_sn, #jqvmap2_gw, #jqvmap2_gn, #jqvmap2_sl, #jqvmap2_lr, #jqvmap2_ci, #jqvmap2_bf, #jqvmap2_gh, #jqvmap2_tg, #jqvmap2_bj, #jqvmap2_ng, #jqvmap2_ug').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2"});
        $('#jqvmap2_mv, #jqvmap2_is, #jqvmap2_no, #jqvmap2_ie, #jqvmap2_gb, #jqvmap2_se, #jqvmap2_fi, #jqvmap2_ee, #jqvmap2_lv, #jqvmap2_lt, #jqvmap2_by, #jqvmap2_ua, #jqvmap2_md, #jqvmap2_ro, #jqvmap2_hu, #jqvmap2_dk, #jqvmap2_de, #jqvmap2_nl, #jqvmap2_be, #jqvmap2_fr, #jqvmap2_it, #jqvmap2_es, #jqvmap2_pt, #jqvmap2_mt, #jqvmap2_cy, #jqvmap2_gr, #jqvmap2_tr, #jqvmap2_sy, #jqvmap2_sa, #jqvmap2_in, #jqvmap2_ru, #jqvmap2_pl, #jqvmap2_cz, #jqvmap2_sk, #jqvmap2_at #jqvmap2_ch, #jqvmap2_si, #jqvmap2_hr, #jqvmap2_ba, #jqvmap2_rs, #jqvmap2_bg, #jqvmap2_mk, #jqvmap2_al, #jqvmap2_lb, #jqvmap2_il, #jqvmap2_jo, #jqvmap2_iq, #jqvmap2_kw, #jqvmap2_qa, #jqvmap2_ae, #jqvmap2_om, #jqvmap2_ye, #jqvmap2_ir, #jqvmap2_ch, #jqvmap2_at, #jqvmap2_ge, #jqvmap2_am, #jqvmap2_az, #jqvmap2_kz, #jqvmap2_mn, #jqvmap2_cn, #jqvmap2_kp, #jqvmap2_kg, #jqvmap2_uz, #jqvmap2_tj, #jqvmap2_tm, #jqvmap2_af, #jqvmap2_pk, #jqvmap2_np, #jqvmap2_bt, #jqvmap2_bd, #jqvmap2_mm, #jqvmap2_th, #jqvmap2_jp, #jqvmap2_kr, #jqvmap2_tw, #jqvmap2_la, #jqvmap2_vn, #jqvmap2_kh, #jqvmap2_lk, #jqvmap2_id, #jqvmap2_my, #jqvmap2_bn, #jqvmap2_ph, #jqvmap2_tl').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2 "});
        $('#jqvmap2_au, #jqvmap2_pg, #jqvmap2_sb, #jqvmap2_vu, #jqvmap2_pf, #jqvmap2_fj, #jqvmap2_nc, #jqvmap2_nz').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2 "});

        region_name = "South America";
        $('.region_title p').html("South America");
    });

    //africa
    $('#jqvmap2_km, #jqvmap2_sc, #jqvmap2_mu, #jqvmap2_re, #jqvmap2_eg, #jqvmap2_ly, #jqvmap2_tn, #jqvmap2_dz, #jqvmap2_ma, #jqvmap2_mr, #jqvmap2_ml, #jqvmap2_ne, #jqvmap2_td, #jqvmap2_sd, #jqvmap2_er, #jqvmap2_dj, #jqvmap2_so, #jqvmap2_et, #jqvmap2_ke, #jqvmap2_cf, #jqvmap2_cm, #jqvmap2_gq, #jqvmap2_st, #jqvmap2_ga, #jqvmap2_cg, #jqvmap2_ao, #jqvmap2_cd, #jqvmap2_rw, #jqvmap2_bi, #jqvmap2_tz, #jqvmap2_zm, #jqvmap2_zw, #jqvmap2_mw, #jqvmap2_mz, #jqvmap2_na, #jqvmap2_bw, #jqvmap2_za, #jqvmap2_ls, #jqvmap2_sz, #jqvmap2_mg, #jqvmap2_cv, #jqvmap2_gm, #jqvmap2_sn, #jqvmap2_gw, #jqvmap2_gn, #jqvmap2_sl, #jqvmap2_lr, #jqvmap2_ci, #jqvmap2_bf, #jqvmap2_gh, #jqvmap2_tg, #jqvmap2_bj, #jqvmap2_ng, #jqvmap2_ug').click(function(){
        $('#jqvmap2_km, #jqvmap2_sc, #jqvmap2_mu, #jqvmap2_re, #jqvmap2_eg, #jqvmap2_ly, #jqvmap2_tn, #jqvmap2_dz, #jqvmap2_ma, #jqvmap2_mr, #jqvmap2_ml, #jqvmap2_ne, #jqvmap2_td, #jqvmap2_sd, #jqvmap2_er, #jqvmap2_dj, #jqvmap2_so, #jqvmap2_et, #jqvmap2_ke, #jqvmap2_cf, #jqvmap2_cm, #jqvmap2_gq, #jqvmap2_st, #jqvmap2_ga, #jqvmap2_cg, #jqvmap2_ao, #jqvmap2_cd, #jqvmap2_rw, #jqvmap2_bi, #jqvmap2_tz, #jqvmap2_zm, #jqvmap2_zw, #jqvmap2_mw, #jqvmap2_mz, #jqvmap2_na, #jqvmap2_bw, #jqvmap2_za, #jqvmap2_ls, #jqvmap2_sz, #jqvmap2_mg, #jqvmap2_cv, #jqvmap2_gm, #jqvmap2_sn, #jqvmap2_gw, #jqvmap2_gn, #jqvmap2_sl, #jqvmap2_lr, #jqvmap2_ci, #jqvmap2_bf, #jqvmap2_gh, #jqvmap2_tg, #jqvmap2_bj, #jqvmap2_ng, #jqvmap2_ug').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#ffa767"});

        $('.eurasia').hide();

        $('#jqvmap2_gl, #jqvmap2_ca, #jqvmap2_us, #jqvmap2_mx, #jqvmap2_gt, #jqvmap2_bz, #jqvmap2_sv, #jqvmap2_hn, #jqvmap2_ni, #jqvmap2_cr, #jqvmap2_pa, #jqvmap2_bs, #jqvmap2_jm, #jqvmap2_cu, #jqvmap2_ht, #jqvmap2_do, #jqvmap2_tt, #jqvmap2_gd, #jqvmap2_bb, #jqvmap2_lc, #jqvmap2_dm, #jqvmap2_ag, #jqvmap2_kn').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2"});
        $('#jqvmap2_fk, #jqvmap2_co, #jqvmap2_ve, #jqvmap2_ec, #jqvmap2_gy, #jqvmap2_sr, #jqvmap2_gf, #jqvmap2_br, #jqvmap2_pe, #jqvmap2_bo, #jqvmap2_py, #jqvmap2_uy, #jqvmap2_ar, #jqvmap2_cl').css({"stroke":"#828282", "stroke-width": "2px", "fill": "#57A0C2"});
        $('#jqvmap2_mv, #jqvmap2_is, #jqvmap2_no, #jqvmap2_ie, #jqvmap2_gb, #jqvmap2_se, #jqvmap2_fi, #jqvmap2_ee, #jqvmap2_lv, #jqvmap2_lt, #jqvmap2_by, #jqvmap2_ua, #jqvmap2_md, #jqvmap2_ro, #jqvmap2_hu, #jqvmap2_dk, #jqvmap2_de, #jqvmap2_nl, #jqvmap2_be, #jqvmap2_fr, #jqvmap2_it, #jqvmap2_es, #jqvmap2_pt, #jqvmap2_mt, #jqvmap2_cy, #jqvmap2_gr, #jqvmap2_tr, #jqvmap2_sy, #jqvmap2_sa, #jqvmap2_in, #jqvmap2_ru, #jqvmap2_pl, #jqvmap2_cz, #jqvmap2_sk, #jqvmap2_at #jqvmap2_ch, #jqvmap2_si, #jqvmap2_hr, #jqvmap2_ba, #jqvmap2_rs, #jqvmap2_bg, #jqvmap2_mk, #jqvmap2_al, #jqvmap2_lb, #jqvmap2_il, #jqvmap2_jo, #jqvmap2_iq, #jqvmap2_kw, #jqvmap2_qa, #jqvmap2_ae, #jqvmap2_om, #jqvmap2_ye, #jqvmap2_ir, #jqvmap2_ch, #jqvmap2_at, #jqvmap2_ge, #jqvmap2_am, #jqvmap2_az, #jqvmap2_kz, #jqvmap2_mn, #jqvmap2_cn, #jqvmap2_kp, #jqvmap2_kg, #jqvmap2_uz, #jqvmap2_tj, #jqvmap2_tm, #jqvmap2_af, #jqvmap2_pk, #jqvmap2_np, #jqvmap2_bt, #jqvmap2_bd, #jqvmap2_mm, #jqvmap2_th, #jqvmap2_jp, #jqvmap2_kr, #jqvmap2_tw, #jqvmap2_la, #jqvmap2_vn, #jqvmap2_kh, #jqvmap2_lk, #jqvmap2_id, #jqvmap2_my, #jqvmap2_bn, #jqvmap2_ph, #jqvmap2_tl').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2 "});
        $('#jqvmap2_au, #jqvmap2_pg, #jqvmap2_sb, #jqvmap2_vu, #jqvmap2_pf, #jqvmap2_fj, #jqvmap2_nc, #jqvmap2_nz').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2 "});

        region_name = "Africa";
        $('.region_title p').html("Africa");
    });

    //eurasia
    $('#jqvmap2_mv, #jqvmap2_is, #jqvmap2_no, #jqvmap2_ie, #jqvmap2_gb, #jqvmap2_se, #jqvmap2_fi, #jqvmap2_ee, #jqvmap2_lv, #jqvmap2_lt, #jqvmap2_by, #jqvmap2_ua, #jqvmap2_md, #jqvmap2_ro, #jqvmap2_hu, #jqvmap2_dk, #jqvmap2_de, #jqvmap2_nl, #jqvmap2_be, #jqvmap2_fr, #jqvmap2_it, #jqvmap2_es, #jqvmap2_pt, #jqvmap2_mt, #jqvmap2_cy, #jqvmap2_gr, #jqvmap2_tr, #jqvmap2_sy, #jqvmap2_sa, #jqvmap2_in, #jqvmap2_ru, #jqvmap2_pl, #jqvmap2_cz, #jqvmap2_sk, #jqvmap2_at #jqvmap2_ch, #jqvmap2_si, #jqvmap2_hr, #jqvmap2_ba, #jqvmap2_rs, #jqvmap2_bg, #jqvmap2_mk, #jqvmap2_al, #jqvmap2_lb, #jqvmap2_il, #jqvmap2_jo, #jqvmap2_iq, #jqvmap2_kw, #jqvmap2_qa, #jqvmap2_ae, #jqvmap2_om, #jqvmap2_ye, #jqvmap2_ir, #jqvmap2_ch, #jqvmap2_at, #jqvmap2_ge, #jqvmap2_am, #jqvmap2_az, #jqvmap2_kz, #jqvmap2_mn, #jqvmap2_cn, #jqvmap2_kp, #jqvmap2_kg, #jqvmap2_uz, #jqvmap2_tj, #jqvmap2_tm, #jqvmap2_af, #jqvmap2_pk, #jqvmap2_np, #jqvmap2_bt, #jqvmap2_bd, #jqvmap2_mm, #jqvmap2_th, #jqvmap2_jp, #jqvmap2_kr, #jqvmap2_tw, #jqvmap2_la, #jqvmap2_vn, #jqvmap2_kh, #jqvmap2_lk, #jqvmap2_id, #jqvmap2_my, #jqvmap2_bn, #jqvmap2_ph, #jqvmap2_tl').click(function(){
        $('#jqvmap2_mv, #jqvmap2_is, #jqvmap2_no, #jqvmap2_ie, #jqvmap2_gb, #jqvmap2_se, #jqvmap2_fi, #jqvmap2_ee, #jqvmap2_lv, #jqvmap2_lt, #jqvmap2_by, #jqvmap2_ua, #jqvmap2_md, #jqvmap2_ro, #jqvmap2_hu, #jqvmap2_dk, #jqvmap2_de, #jqvmap2_nl, #jqvmap2_be, #jqvmap2_fr, #jqvmap2_it, #jqvmap2_es, #jqvmap2_pt, #jqvmap2_mt, #jqvmap2_cy, #jqvmap2_gr, #jqvmap2_tr, #jqvmap2_sy, #jqvmap2_sa, #jqvmap2_in, #jqvmap2_ru, #jqvmap2_pl, #jqvmap2_cz, #jqvmap2_sk, #jqvmap2_at #jqvmap2_ch, #jqvmap2_si, #jqvmap2_hr, #jqvmap2_ba, #jqvmap2_rs, #jqvmap2_bg, #jqvmap2_mk, #jqvmap2_al, #jqvmap2_lb, #jqvmap2_il, #jqvmap2_jo, #jqvmap2_iq, #jqvmap2_kw, #jqvmap2_qa, #jqvmap2_ae, #jqvmap2_om, #jqvmap2_ye, #jqvmap2_ir, #jqvmap2_ch, #jqvmap2_at, #jqvmap2_ge, #jqvmap2_am, #jqvmap2_az, #jqvmap2_kz, #jqvmap2_mn, #jqvmap2_cn, #jqvmap2_kp, #jqvmap2_kg, #jqvmap2_uz, #jqvmap2_tj, #jqvmap2_tm, #jqvmap2_af, #jqvmap2_pk, #jqvmap2_np, #jqvmap2_bt, #jqvmap2_bd, #jqvmap2_mm, #jqvmap2_th, #jqvmap2_jp, #jqvmap2_kr, #jqvmap2_tw, #jqvmap2_la, #jqvmap2_vn, #jqvmap2_kh, #jqvmap2_lk, #jqvmap2_id, #jqvmap2_my, #jqvmap2_bn, #jqvmap2_ph, #jqvmap2_tl').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#ffa767 "});

        $('.region_title p').html('');

        $('#jqvmap2_fk, #jqvmap2_co, #jqvmap2_ve, #jqvmap2_ec, #jqvmap2_gy, #jqvmap2_sr, #jqvmap2_gf, #jqvmap2_br, #jqvmap2_pe, #jqvmap2_bo, #jqvmap2_py, #jqvmap2_uy, #jqvmap2_ar, #jqvmap2_cl').css({"stroke":"#828282", "stroke-width": "2px", "fill": "#57A0C2"});
        $('#jqvmap2_gl, #jqvmap2_ca, #jqvmap2_us, #jqvmap2_mx, #jqvmap2_gt, #jqvmap2_bz, #jqvmap2_sv, #jqvmap2_hn, #jqvmap2_ni, #jqvmap2_cr, #jqvmap2_pa, #jqvmap2_bs, #jqvmap2_jm, #jqvmap2_cu, #jqvmap2_ht, #jqvmap2_do, #jqvmap2_tt, #jqvmap2_gd, #jqvmap2_bb, #jqvmap2_lc, #jqvmap2_dm, #jqvmap2_ag, #jqvmap2_kn').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2"});
        $('#jqvmap2_km, #jqvmap2_sc, #jqvmap2_mu, #jqvmap2_re, #jqvmap2_eg, #jqvmap2_ly, #jqvmap2_tn, #jqvmap2_dz, #jqvmap2_ma, #jqvmap2_mr, #jqvmap2_ml, #jqvmap2_ne, #jqvmap2_td, #jqvmap2_sd, #jqvmap2_er, #jqvmap2_dj, #jqvmap2_so, #jqvmap2_et, #jqvmap2_ke, #jqvmap2_cf, #jqvmap2_cm, #jqvmap2_gq, #jqvmap2_st, #jqvmap2_ga, #jqvmap2_cg, #jqvmap2_ao, #jqvmap2_cd, #jqvmap2_rw, #jqvmap2_bi, #jqvmap2_tz, #jqvmap2_zm, #jqvmap2_zw, #jqvmap2_mw, #jqvmap2_mz, #jqvmap2_na, #jqvmap2_bw, #jqvmap2_za, #jqvmap2_ls, #jqvmap2_sz, #jqvmap2_mg, #jqvmap2_cv, #jqvmap2_gm, #jqvmap2_sn, #jqvmap2_gw, #jqvmap2_gn, #jqvmap2_sl, #jqvmap2_lr, #jqvmap2_ci, #jqvmap2_bf, #jqvmap2_gh, #jqvmap2_tg, #jqvmap2_bj, #jqvmap2_ng, #jqvmap2_ug').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2"});
        $('#jqvmap2_au, #jqvmap2_pg, #jqvmap2_sb, #jqvmap2_vu, #jqvmap2_pf, #jqvmap2_fj, #jqvmap2_nc, #jqvmap2_nz').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2 "});

        $('.eurasia').show();

        $(".eurasia").on('change', function(){
            region_name = $('input[name="eurasia"]:checked').val();
            $('.region_title p').html($('input[name="eurasia"]:checked').val());
        });


    });

    //australia
    $('#jqvmap2_au, #jqvmap2_pg, #jqvmap2_sb, #jqvmap2_vu, #jqvmap2_pf, #jqvmap2_fj, #jqvmap2_nc, #jqvmap2_nz').click(function(){
        $('#jqvmap2_au, #jqvmap2_pg, #jqvmap2_sb, #jqvmap2_vu, #jqvmap2_pf, #jqvmap2_fj, #jqvmap2_nc, #jqvmap2_nz').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#ffa767 "});

        $('.eurasia').hide();

        $('#jqvmap2_fk, #jqvmap2_co, #jqvmap2_ve, #jqvmap2_ec, #jqvmap2_gy, #jqvmap2_sr, #jqvmap2_gf, #jqvmap2_br, #jqvmap2_pe, #jqvmap2_bo, #jqvmap2_py, #jqvmap2_uy, #jqvmap2_ar, #jqvmap2_cl').css({"stroke":"#828282", "stroke-width": "2px", "fill": "#57A0C2"});
        $('#jqvmap2_gl, #jqvmap2_ca, #jqvmap2_us, #jqvmap2_mx, #jqvmap2_gt, #jqvmap2_bz, #jqvmap2_sv, #jqvmap2_hn, #jqvmap2_ni, #jqvmap2_cr, #jqvmap2_pa, #jqvmap2_bs, #jqvmap2_jm, #jqvmap2_cu, #jqvmap2_ht, #jqvmap2_do, #jqvmap2_tt, #jqvmap2_gd, #jqvmap2_bb, #jqvmap2_lc, #jqvmap2_dm, #jqvmap2_ag, #jqvmap2_kn').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2"});
        $('#jqvmap2_km, #jqvmap2_sc, #jqvmap2_mu, #jqvmap2_re, #jqvmap2_eg, #jqvmap2_ly, #jqvmap2_tn, #jqvmap2_dz, #jqvmap2_ma, #jqvmap2_mr, #jqvmap2_ml, #jqvmap2_ne, #jqvmap2_td, #jqvmap2_sd, #jqvmap2_er, #jqvmap2_dj, #jqvmap2_so, #jqvmap2_et, #jqvmap2_ke, #jqvmap2_cf, #jqvmap2_cm, #jqvmap2_gq, #jqvmap2_st, #jqvmap2_ga, #jqvmap2_cg, #jqvmap2_ao, #jqvmap2_cd, #jqvmap2_rw, #jqvmap2_bi, #jqvmap2_tz, #jqvmap2_zm, #jqvmap2_zw, #jqvmap2_mw, #jqvmap2_mz, #jqvmap2_na, #jqvmap2_bw, #jqvmap2_za, #jqvmap2_ls, #jqvmap2_sz, #jqvmap2_mg, #jqvmap2_cv, #jqvmap2_gm, #jqvmap2_sn, #jqvmap2_gw, #jqvmap2_gn, #jqvmap2_sl, #jqvmap2_lr, #jqvmap2_ci, #jqvmap2_bf, #jqvmap2_gh, #jqvmap2_tg, #jqvmap2_bj, #jqvmap2_ng, #jqvmap2_ug').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2"});
        $('#jqvmap2_mv, #jqvmap2_is, #jqvmap2_no, #jqvmap2_ie, #jqvmap2_gb, #jqvmap2_se, #jqvmap2_fi, #jqvmap2_ee, #jqvmap2_lv, #jqvmap2_lt, #jqvmap2_by, #jqvmap2_ua, #jqvmap2_md, #jqvmap2_ro, #jqvmap2_hu, #jqvmap2_dk, #jqvmap2_de, #jqvmap2_nl, #jqvmap2_be, #jqvmap2_fr, #jqvmap2_it, #jqvmap2_es, #jqvmap2_pt, #jqvmap2_mt, #jqvmap2_cy, #jqvmap2_gr, #jqvmap2_tr, #jqvmap2_sy, #jqvmap2_sa, #jqvmap2_in, #jqvmap2_ru, #jqvmap2_pl, #jqvmap2_cz, #jqvmap2_sk, #jqvmap2_at #jqvmap2_ch, #jqvmap2_si, #jqvmap2_hr, #jqvmap2_ba, #jqvmap2_rs, #jqvmap2_bg, #jqvmap2_mk, #jqvmap2_al, #jqvmap2_lb, #jqvmap2_il, #jqvmap2_jo, #jqvmap2_iq, #jqvmap2_kw, #jqvmap2_qa, #jqvmap2_ae, #jqvmap2_om, #jqvmap2_ye, #jqvmap2_ir, #jqvmap2_ch, #jqvmap2_at, #jqvmap2_ge, #jqvmap2_am, #jqvmap2_az, #jqvmap2_kz, #jqvmap2_mn, #jqvmap2_cn, #jqvmap2_kp, #jqvmap2_kg, #jqvmap2_uz, #jqvmap2_tj, #jqvmap2_tm, #jqvmap2_af, #jqvmap2_pk, #jqvmap2_np, #jqvmap2_bt, #jqvmap2_bd, #jqvmap2_mm, #jqvmap2_th, #jqvmap2_jp, #jqvmap2_kr, #jqvmap2_tw, #jqvmap2_la, #jqvmap2_vn, #jqvmap2_kh, #jqvmap2_lk, #jqvmap2_id, #jqvmap2_my, #jqvmap2_bn, #jqvmap2_ph, #jqvmap2_tl').css({"stroke":"#666666", "stroke-width": "2px", "fill": "#57A0C2 "});

        region_name = "Australia";
        $('.region_title p').html("Australia");
    });






    //west
    $('#jqvmap1_wy, #jqvmap1_wa, #jqvmap1_mt, #jqvmap1_id, #jqvmap1_or, #jqvmap1_ca, #jqvmap1_nv, #jqvmap1_ut, #jqvmap1_co, #jqvmap1_mt, #jqvmap1_nm, #jqvmap1_ak, #jqvmap1_hi, #jqvmap1_az').click(function(){
        $('#jqvmap1_wy, #jqvmap1_wa, #jqvmap1_mt, #jqvmap1_id, #jqvmap1_or, #jqvmap1_ca, #jqvmap1_nv, #jqvmap1_ut, #jqvmap1_co, #jqvmap1_mt, #jqvmap1_nm, #jqvmap1_ak, #jqvmap1_hi, #jqvmap1_az').css({"stroke":"#666666", "stroke-width": "1px", "fill": "#ffa767"});

        $('#jqvmap1_nd, #jqvmap1_sd, #jqvmap1_ne, #jqvmap1_ks, #jqvmap1_mn, #jqvmap1_ia, #jqvmap1_mo, #jqvmap1_il, #jqvmap1_wi, #jqvmap1_mi, #jqvmap1_in, #jqvmap1_oh, #jqvmap1_mi ').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
        $('#jqvmap1_nj, #jqvmap1_pa, #jqvmap1_ny, #jqvmap1_vt, #jqvmap1_ct, #jqvmap1_ri, #jqvmap1_ma, #jqvmap1_nh, #jqvmap1_me').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
        $('#jqvmap1_tx, #jqvmap1_ok, #jqvmap1_la, #jqvmap1_ar, #jqvmap1_ms, #jqvmap1_fl, #jqvmap1_al, #jqvmap1_tn, #jqvmap1_ky, #jqvmap1_sc, #jqvmap1_va, #jqvmap1_wv, #jqvmap1_md, #jqvmap1_de, #jqvmap1_ga, #jqvmap1_nc').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});

        region_name_us = "West";
        $('.region_title p').html("US West");
    });

    //midwest
    $('#jqvmap1_nd, #jqvmap1_sd, #jqvmap1_ne, #jqvmap1_ks, #jqvmap1_mn, #jqvmap1_ia, #jqvmap1_mo, #jqvmap1_il, #jqvmap1_wi, #jqvmap1_mi, #jqvmap1_in, #jqvmap1_oh, #jqvmap1_mi ').click(function(){
        $('#jqvmap1_nd, #jqvmap1_sd, #jqvmap1_ne, #jqvmap1_ks, #jqvmap1_mn, #jqvmap1_ia, #jqvmap1_mo, #jqvmap1_il, #jqvmap1_wi, #jqvmap1_mi, #jqvmap1_in, #jqvmap1_oh, #jqvmap1_mi ').css({"stroke":"#666666", "stroke-width": "1px", "fill": "#ffa767"});

        $('#jqvmap1_wy, #jqvmap1_wa, #jqvmap1_mt, #jqvmap1_id, #jqvmap1_or, #jqvmap1_ca, #jqvmap1_nv, #jqvmap1_ut, #jqvmap1_co, #jqvmap1_mt, #jqvmap1_nm, #jqvmap1_ak, #jqvmap1_hi, #jqvmap1_az').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
        $('#jqvmap1_nj, #jqvmap1_pa, #jqvmap1_ny, #jqvmap1_vt, #jqvmap1_ct, #jqvmap1_ri, #jqvmap1_ma, #jqvmap1_nh, #jqvmap1_me').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
        $('#jqvmap1_tx, #jqvmap1_ok, #jqvmap1_la, #jqvmap1_ar, #jqvmap1_ms, #jqvmap1_fl, #jqvmap1_al, #jqvmap1_tn, #jqvmap1_ky, #jqvmap1_sc, #jqvmap1_va, #jqvmap1_wv, #jqvmap1_md, #jqvmap1_de, #jqvmap1_ga, #jqvmap1_nc').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});

        region_name_us = "Midwest";
        $('.region_title p').html("US Midwest");
    });

    //north-east
    $('#jqvmap1_nj, #jqvmap1_pa, #jqvmap1_ny, #jqvmap1_vt, #jqvmap1_ct, #jqvmap1_ri, #jqvmap1_ma, #jqvmap1_nh, #jqvmap1_me').click(function(){
        $('#jqvmap1_nj, #jqvmap1_pa, #jqvmap1_ny, #jqvmap1_vt, #jqvmap1_ct, #jqvmap1_ri, #jqvmap1_ma, #jqvmap1_nh, #jqvmap1_me').css({"stroke":"#666666", "stroke-width": "1px", "fill": "#ffa767"});

        $('#jqvmap1_nd, #jqvmap1_sd, #jqvmap1_ne, #jqvmap1_ks, #jqvmap1_mn, #jqvmap1_ia, #jqvmap1_mo, #jqvmap1_il, #jqvmap1_wi, #jqvmap1_mi, #jqvmap1_in, #jqvmap1_oh, #jqvmap1_mi ').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
        $('#jqvmap1_wy, #jqvmap1_wa, #jqvmap1_mt, #jqvmap1_id, #jqvmap1_or, #jqvmap1_ca, #jqvmap1_nv, #jqvmap1_ut, #jqvmap1_co, #jqvmap1_mt, #jqvmap1_nm, #jqvmap1_ak, #jqvmap1_hi, #jqvmap1_az').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
        $('#jqvmap1_tx, #jqvmap1_ok, #jqvmap1_la, #jqvmap1_ar, #jqvmap1_ms, #jqvmap1_fl, #jqvmap1_al, #jqvmap1_tn, #jqvmap1_ky, #jqvmap1_sc, #jqvmap1_va, #jqvmap1_wv, #jqvmap1_md, #jqvmap1_de, #jqvmap1_ga, #jqvmap1_nc').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});

        region_name_us = "Northeast";
        $('.region_title p').html("US Northeast");
    });

    //south
    $('#jqvmap1_tx, #jqvmap1_ok, #jqvmap1_la, #jqvmap1_ar, #jqvmap1_ms, #jqvmap1_fl, #jqvmap1_al, #jqvmap1_tn, #jqvmap1_ky, #jqvmap1_sc, #jqvmap1_va, #jqvmap1_wv, #jqvmap1_md, #jqvmap1_de, #jqvmap1_ga, #jqvmap1_nc').click(function(){
        $('#jqvmap1_tx, #jqvmap1_ok, #jqvmap1_la, #jqvmap1_ar, #jqvmap1_ms, #jqvmap1_fl, #jqvmap1_al, #jqvmap1_tn, #jqvmap1_ky, #jqvmap1_sc, #jqvmap1_va, #jqvmap1_wv, #jqvmap1_md, #jqvmap1_de, #jqvmap1_ga, #jqvmap1_nc').css({"stroke":"#666666", "stroke-width": "1px", "fill": "#ffa767"});

        $('#jqvmap1_nd, #jqvmap1_sd, #jqvmap1_ne, #jqvmap1_ks, #jqvmap1_mn, #jqvmap1_ia, #jqvmap1_mo, #jqvmap1_il, #jqvmap1_wi, #jqvmap1_mi, #jqvmap1_in, #jqvmap1_oh, #jqvmap1_mi ').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
        $('#jqvmap1_nj, #jqvmap1_pa, #jqvmap1_ny, #jqvmap1_vt, #jqvmap1_ct, #jqvmap1_ri, #jqvmap1_ma, #jqvmap1_nh, #jqvmap1_me').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
        $('#jqvmap1_wy, #jqvmap1_wa, #jqvmap1_mt, #jqvmap1_id, #jqvmap1_or, #jqvmap1_ca, #jqvmap1_nv, #jqvmap1_ut, #jqvmap1_co, #jqvmap1_mt, #jqvmap1_nm, #jqvmap1_ak, #jqvmap1_hi, #jqvmap1_az').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});

        region_name_us = "South";
        $('.region_title p').html("US South");
    });


    var report_data_table = $("#report_surveys").dataTable({
        "sDom": '<"H"flr>t<"F"ip>',
        "bDestroy":true,
        "bJQueryUI": true,
        "bRetrieve": true,
        "aaSorting": [],
        "bProcessing": true,
        "sServerMethod": "POST",
        "sAjaxSource": "/dashboard/getSurveys",
        "bDeferRender": true,
        "iDisplayLength": 25,
        "aLengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],
        "sScrollX": "100%",
        "bScrollCollapse": true,
        "oLanguage": {
            "sInfo"      : "_END_ of _TOTAL_ entries",
            "sInfoEmpty" : "_END_ of _TOTAL_ entries",
            "sLengthMenu": "Display _MENU_"
        },
        "aoColumnDefs": [
            { "sClass": "datatable_td_align_center_checkboxes", "aTargets": [0]},
            { "sClass": "datatable_td_align_center", "aTargets": ["_all"]},            
            { "bVisible": false, "aTargets": [ 4,5,6,8,9,10,12,13,14 ] },
            { "bVisible": true, "aTargets": [ 0,1,2,3,7,11,15 ] },
            { "bSortable": false, "aTargets": [ 0,15 ] }
        ]

    });
    
    /**
     *  Add tooltip for search field in dataTable
     */
    $("#report_surveys_filter").find("label").attr("title", "Enter a keyword of interest (ex. Litigation) to refine the results.");

    // Filtering
    $(".other_filters_block input:checkbox").change(function() {
        filterByOtherParameters(report_data_table, $(this));                    
    });

    $("#region_selected").on("click", function() {
        var region;
        $('.region_checkbox').prop('checked',false);
        if(region_name!='')
        {
            region = region_name;
            $('input[value="'+region+'"]').click();
            $('#jqvmap2_gl, #jqvmap2_ca, #jqvmap2_us, #jqvmap2_mx, #jqvmap2_gt, #jqvmap2_bz, #jqvmap2_sv, #jqvmap2_hn, #jqvmap2_ni, #jqvmap2_cr, #jqvmap2_pa, #jqvmap2_bs, #jqvmap2_jm, #jqvmap2_cu, #jqvmap2_ht, #jqvmap2_do, #jqvmap2_tt, #jqvmap2_gd, #jqvmap2_bb, #jqvmap2_lc, #jqvmap2_dm, #jqvmap2_ag, #jqvmap2_kn').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
            $('#jqvmap2_fk, #jqvmap2_co, #jqvmap2_ve, #jqvmap2_ec, #jqvmap2_gy, #jqvmap2_sr, #jqvmap2_gf, #jqvmap2_br, #jqvmap2_pe, #jqvmap2_bo, #jqvmap2_py, #jqvmap2_uy, #jqvmap2_ar, #jqvmap2_cl').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
            $('#jqvmap2_km, #jqvmap2_sc, #jqvmap2_mu, #jqvmap2_re, #jqvmap2_eg, #jqvmap2_ly, #jqvmap2_tn, #jqvmap2_dz, #jqvmap2_ma, #jqvmap2_mr, #jqvmap2_ml, #jqvmap2_ne, #jqvmap2_td, #jqvmap2_sd, #jqvmap2_er, #jqvmap2_dj, #jqvmap2_so, #jqvmap2_et, #jqvmap2_ke, #jqvmap2_cf, #jqvmap2_cm, #jqvmap2_gq, #jqvmap2_st, #jqvmap2_ga, #jqvmap2_cg, #jqvmap2_ao, #jqvmap2_cd, #jqvmap2_rw, #jqvmap2_bi, #jqvmap2_tz, #jqvmap2_zm, #jqvmap2_zw, #jqvmap2_mw, #jqvmap2_mz, #jqvmap2_na, #jqvmap2_bw, #jqvmap2_za, #jqvmap2_ls, #jqvmap2_sz, #jqvmap2_mg, #jqvmap2_cv, #jqvmap2_gm, #jqvmap2_sn, #jqvmap2_gw, #jqvmap2_gn, #jqvmap2_sl, #jqvmap2_lr, #jqvmap2_ci, #jqvmap2_bf, #jqvmap2_gh, #jqvmap2_tg, #jqvmap2_bj, #jqvmap2_ng, #jqvmap2_ug').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
            $('#jqvmap2_mv, #jqvmap2_is, #jqvmap2_no, #jqvmap2_ie, #jqvmap2_gb, #jqvmap2_se, #jqvmap2_fi, #jqvmap2_ee, #jqvmap2_lv, #jqvmap2_lt, #jqvmap2_by, #jqvmap2_ua, #jqvmap2_md, #jqvmap2_ro, #jqvmap2_hu, #jqvmap2_dk, #jqvmap2_de, #jqvmap2_nl, #jqvmap2_be, #jqvmap2_fr, #jqvmap2_it, #jqvmap2_es, #jqvmap2_pt, #jqvmap2_mt, #jqvmap2_cy, #jqvmap2_gr, #jqvmap2_tr, #jqvmap2_sy, #jqvmap2_sa, #jqvmap2_in, #jqvmap2_ru, #jqvmap2_pl, #jqvmap2_cz, #jqvmap2_sk, #jqvmap2_at #jqvmap2_ch, #jqvmap2_si, #jqvmap2_hr, #jqvmap2_ba, #jqvmap2_rs, #jqvmap2_bg, #jqvmap2_mk, #jqvmap2_al, #jqvmap2_lb, #jqvmap2_il, #jqvmap2_jo, #jqvmap2_iq, #jqvmap2_kw, #jqvmap2_qa, #jqvmap2_ae, #jqvmap2_om, #jqvmap2_ye, #jqvmap2_ir, #jqvmap2_ch, #jqvmap2_at, #jqvmap2_ge, #jqvmap2_am, #jqvmap2_az, #jqvmap2_kz, #jqvmap2_mn, #jqvmap2_cn, #jqvmap2_kp, #jqvmap2_kg, #jqvmap2_uz, #jqvmap2_tj, #jqvmap2_tm, #jqvmap2_af, #jqvmap2_pk, #jqvmap2_np, #jqvmap2_bt, #jqvmap2_bd, #jqvmap2_mm, #jqvmap2_th, #jqvmap2_jp, #jqvmap2_kr, #jqvmap2_tw, #jqvmap2_la, #jqvmap2_vn, #jqvmap2_kh, #jqvmap2_lk, #jqvmap2_id, #jqvmap2_my, #jqvmap2_bn, #jqvmap2_ph, #jqvmap2_tl').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
            $('#jqvmap2_au, #jqvmap2_pg, #jqvmap2_sb, #jqvmap2_vu, #jqvmap2_pf, #jqvmap2_fj, #jqvmap2_nc, #jqvmap2_nz').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
        }
        if(region_name_us!='')
        {
            region = region_name_us;
            $('input[value="US '+region+'"]').click();

            $('#jqvmap1_wy, #jqvmap1_wa, #jqvmap1_mt, #jqvmap1_id, #jqvmap1_or, #jqvmap1_ca, #jqvmap1_nv, #jqvmap1_ut, #jqvmap1_co, #jqvmap1_mt, #jqvmap1_nm, #jqvmap1_ak, #jqvmap1_hi, #jqvmap1_az').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
            $('#jqvmap1_nd, #jqvmap1_sd, #jqvmap1_ne, #jqvmap1_ks, #jqvmap1_mn, #jqvmap1_ia, #jqvmap1_mo, #jqvmap1_il, #jqvmap1_wi, #jqvmap1_mi, #jqvmap1_in, #jqvmap1_oh, #jqvmap1_mi ').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
            $('#jqvmap1_nj, #jqvmap1_pa, #jqvmap1_ny, #jqvmap1_vt, #jqvmap1_ct, #jqvmap1_ri, #jqvmap1_ma, #jqvmap1_nh, #jqvmap1_me').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});
            $('#jqvmap1_tx, #jqvmap1_ok, #jqvmap1_la, #jqvmap1_ar, #jqvmap1_ms, #jqvmap1_fl, #jqvmap1_al, #jqvmap1_tn, #jqvmap1_ky, #jqvmap1_sc, #jqvmap1_va, #jqvmap1_wv, #jqvmap1_md, #jqvmap1_de, #jqvmap1_ga, #jqvmap1_nc').css({"stroke":"#818181", "stroke-width": "1px", "fill": "57A0C1"});

        }
        $('.eurasia').hide();
        $('#vmap').hide();
        $('#vmap1').hide();
        region_name = '';
        region_name_us = '';
        $('.region_title p').html('');

        $('.dialog_for_map').dialog("close");

    });

    $(".deadline input:checkbox").on("change", function() {      
        if($(this).is(":checked")) {
            $(".deadline input:checkbox").prop("checked", false);
            $(this).prop("checked", true);
        } else {
            $(this).prop("checked", false);
            $(".deadline input:checkbox").prop("checked", false);                
        }
        
        report_data_table.fnDraw();
    });
    // End of filtering

    /**
     *  Display/Hide Columns
     */
    $("#display_form input:checkbox").change(function() {
        $("#change_data_table").val(0);
        
        var checked_count = 0;
        $("#display_form input:checkbox:checked").each(function(index, element) {
            checked_count++;
        });
        
        var report_data_table = $("#report_surveys").dataTable();
        
        var column_number = $(this).attr("col_num");
        var show_status   = $(this).is(":checked");

        // Get show status for static columns
        var static_col_show_status = true;
        if(checked_count == 0) {
            static_col_show_status = false;
        }   
        
        // Show/Hide static column
        showAndHideColumns(0, static_col_show_status, report_data_table);
        showAndHideColumns(15, static_col_show_status, report_data_table);

        showAndHideColumns(column_number, show_status, report_data_table); 
    });

    /**
     *  Display management links
     */
    $("#default_display").click(function() {
        $("#display_form .default_display_checkbox").each(function() {
            if(this.checked == false) {
                this.checked = true;

                var column_number = $(this).attr("col_num");

                // Show static column
                showAndHideColumns(0, true, report_data_table);
                showAndHideColumns(15, true, report_data_table);

                showAndHideColumns(column_number, true, report_data_table);
            }
        });

        $("#display_form .not_default_display_checkbox").each(function() {
            if(this.checked) {
                this.checked = false;

                var column_number = $(this).attr("col_num");

                // Show static column
                showAndHideColumns(0, true, report_data_table);
                showAndHideColumns(15, true, report_data_table);

                showAndHideColumns(column_number, false, report_data_table);
            }
        });

        return false;
    }); 

    $("#select_all_display").click(function() {
        $("#display_form input:checkbox").each(function() {
            if(this.checked == false) {
                this.checked = true;

                var column_number = $(this).attr("col_num");

                // Show static column
                showAndHideColumns(0, true, report_data_table);
                showAndHideColumns(15, true, report_data_table);
                
                // Show other columns
                showAndHideColumns(column_number, true, report_data_table);
            }
        });

        return false;
    });

    $("#clear_all_display").click(function() {
        $("#display_form input:checkbox").each(function() {
            if(this.checked) {
                this.checked = false;

                var column_number = $(this).attr("col_num");
                
                // Hide static column
                showAndHideColumns(0, false, report_data_table);
                showAndHideColumns(15, false, report_data_table);
                
                // Hide other columns
                showAndHideColumns(column_number, false, report_data_table);
            }
        });

        return false;
    });
    
    /**
     *  Construction of hidden filter form
     */    
    $(document).on("change", ".other_filters_block input:checkbox", function() {
        var filter_value = $(this).val();
        
        if(this.checked) {
            addCheckboxHiddenFilter($(this).attr("checkbox_type"), filter_value, true);
        } else {
            addCheckboxHiddenFilter($(this).attr("checkbox_type"), filter_value, false);
        }        
    });
    
    $(document).on("change", ".deadline_checkbox", function() {
        if(this.checked) {
            addDeadlineCheckboxHiddenFilter($(this).attr("checkbox_type"), $(this).attr("id"), true);
        } else {
            addDeadlineCheckboxHiddenFilter($(this).attr("checkbox_type"), $(this).attr("id"), false);
        }        
    });
    
    /**
     * Clear filters
     */
    $(document).on("click", "#clear_filters", function() {
        // Clear filter checkboxes
        $(".other_filters_block input:checkbox, .deadline input:checkbox").prop("checked", false);
        
        // Clear hidden filters
        $("#hidden_filters_block select").html('<option value="0"></option>');
        
        // Reset filters
        report_data_table.fnFilter('');
        var colCount = report_data_table.fnGetData(0).length;
        for (var i = 0; i <= colCount; i++) {
            report_data_table.fnFilter('', i);
        }

        return false;
    })
    /**
     * End of "Clear filters"
     */
    
    /**
     * DataTable checkboxes functionality
     */
    $(document).on("change", "#table_checkbox_select_all", function() {
      var check_status = $(this).is(":checked");
      
      $(".table_checkbox").prop("checked", check_status);
      
      return false;
    })
    /**
     * End of "DataTable checkboxes functionality"
     */
});

/**
 * Filtering by other parameters
 * 
 * @param {object} data_table       DataTable object
 * @param {object} element          Filter element object
 */
function filterByOtherParameters(data_table, element) {
    var filter_column = "0";
    if($("#change_data_table").val() == "0") {
        filter_column = element.attr("col_num");
    }

    var current_class = element.attr("class");

    var filter_value = $('.' + current_class + ':checked').map(function () {
        return this.value;
    }).toArray().join('|');

    if($("#change_data_table").val() == "1" && $("#filter_year").val() != "0") {
        if(filter_value == "") {
            filter_value = $("#filter_year").val();
        } else {
            filter_value = filter_value + '|' + $("#filter_year").val();
        }
    }

    filterReportDataTable(data_table, filter_value, filter_column);
}

/**
 * Add hidden filter for deadline field
 * 
 * @param {string}  hidden_filter_id                ID of filter field
 * @param {string}  hidden_filter_value             Value of filter field
 * @param {bool}    hidden_filter_selected_flag     Selected flag for filter field
 */
function addDeadlineCheckboxHiddenFilter(hidden_filter_id, hidden_filter_value, hidden_filter_selected_flag) {
    if(hidden_filter_selected_flag) {
        $("#filter_" + hidden_filter_id).html('<option value="' + hidden_filter_value + '" selected="selected">' + hidden_filter_value + '</option>');
    } else {
        $("#filter_" + hidden_filter_id).html('<option value=""></option>');
    }        
}

/**
 * Add hidden filter for fields
 * 
 * @param {string}  hidden_filter_id                ID of filter field
 * @param {string}  hidden_filter_value             Value of filter field
 * @param {bool}    hidden_filter_selected_flag     Selected flag for filter field
 */
function addCheckboxHiddenFilter(hidden_filter_id, hidden_filter_value, hidden_filter_selected_flag) {
    if(hidden_filter_selected_flag) {
        if($("#filter_" + hidden_filter_id + " option[value='" + hidden_filter_value + "']").val() == undefined) {
            $("#filter_" + hidden_filter_id).append('<option value="' + hidden_filter_value + '" selected="selected">' + hidden_filter_value + '</option>');
        }
    } else {
        $("#filter_" + hidden_filter_id + " option[value='" + hidden_filter_value + "']").remove();
    }        
}

/**
 * Show/Hide columns
 *  
 * @param {integer}     column_number       Number of column
 * @param {bool}        show_status         Show status
 * @param {object}      report_data_table   Object of data table
 */
function showAndHideColumns(column_number, show_status, report_data_table) {
    var bVis = report_data_table.fnSettings().aoColumns[column_number].bVisible;
    
    if((show_status && !bVis) || (!show_status && bVis)) {
        report_data_table.fnSetColumnVis(column_number, show_status);
    }
}

/**
 * Filtering of report table
 * 
 * @param {object}  filter_data_table       Object of data table
 * @param {string}  filter_value            Filter value
 * @param {integer} filter_column           Filter column
 */
function filterReportDataTable(filter_data_table, filter_value, filter_column) {
    filter_data_table.fnFilter( filter_value, filter_column, true, false );
}


$.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) {
        if($(".deadline_checkbox:checked").val() != undefined) {
            var current_date_object = new Date();
            
            var first_date, last_date;
            
            switch($(".deadline_checkbox:checked").val()) {
                case "this_month" :
                    first_date = dateFormat(new Date(current_date_object.getFullYear(), current_date_object.getMonth(), 1), "dd-mmm-yyyy");
                    last_date  = dateFormat(new Date(current_date_object.getFullYear(), current_date_object.getMonth() + 1, 0), "dd-mmm-yyyy");

                    break;
                case "this_quarter" :                  
                    var quarter    = Math.floor((current_date_object.getMonth() / 3));
                    var begin_date = new Date(current_date_object.getFullYear(), quarter * 3, 1);
                    
                    first_date  = dateFormat(begin_date, "dd-mmm-yyyy");
                    last_date   = dateFormat(new Date(begin_date.getFullYear(), begin_date.getMonth() + 3, 0), "dd-mmm-yyyy");

                    break;

                case "this_year" :
                    var current_year = current_date_object.getFullYear();
                    first_date       = dateFormat(new Date( current_year, 0, 1 ), "dd-mmm-yyyy");
                    last_date        = dateFormat(new Date( current_year + 1, 0, 0 ), "dd-mmm-yyyy");

                    break;
                case "next_year" :
                    var next_year = current_date_object.getFullYear() + 1;
                    first_date    = dateFormat(new Date( next_year, 0, 1 ), "dd-mmm-yyyy");
                    last_date     = dateFormat(new Date( next_year + 1, 0, 0 ), "dd-mmm-yyyy");

                    break;

                case "next_quarter" :
                    var next_quarter    = Math.floor((current_date_object.getMonth() / 3));
                    var begin_date = new Date(current_date_object.getFullYear(), next_quarter * 3, 1);

                    //first_date  = dateFormat(begin_date, "dd-mmm-yyyy");
                    first_date   = dateFormat(new Date(begin_date.getFullYear(), begin_date.getMonth() + 3, 0), "dd-mmm-yyyy");
                    last_date   = dateFormat(new Date(begin_date.getFullYear(), begin_date.getMonth() + 6, 0), "dd-mmm-yyyy");

                    break;


            }
            
            if(aData[11] !== '- - -' && new Date(Date.fromString(aData[11])).getTime() >= new Date(Date.fromString(first_date)).getTime() && new Date(Date.fromString(aData[11])).getTime() <= new Date(Date.fromString(last_date)).getTime()) {
                return true;
            }

        } else {
            return true;
        }

        return false;
    }
);