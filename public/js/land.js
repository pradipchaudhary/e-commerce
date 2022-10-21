function calculate(param) {
    var totalArea1 = 0;
    var totalArea2 = 0;
    var totalArea3 = 0;
    var totalArea4 = 0;
    var area1 = 0;
    var area2 = 0;
    var area3 = 0;
    var area4 = 0;
    var total_area = 0;
    var total = 0;
    var bargha_individual = 0;
    var loop = param ? j : k;

    for (re = 4; re <= x; re++) {
        $("#remove" + re).html("");
    }

    for (let i = 1; i <= loop; i++) {

        var is_bajho = $("#is_bajho_" + i).is(":checked");
        var is_charan_kharka = $("#is_charan_kharka_" + i).is(":checked");
        var ar1 = +$("#area1_" + i).val() == undefined ? 0 : +$("#area1_" + i).val();
        var ar2 = +$("#area2_" + i).val() == undefined ? 0 : +$("#area2_" + i).val();
        var ar3 = +$("#area3_" + i).val() == undefined ? 0 : +$("#area3_" + i).val();
        var ar4 = $("#area4_" + i).val() == undefined ? 0 : +$("#area4_" + i).val();

        if (param) {
            bargha_individual = ar1 * 6772.5752 + ar2 * 338.6287 + ar3 * 16.9314;
        } else {
            bargha_individual = ar1 * 508.7328 + ar2 * 31.7958 + ar3 * 7.9487 + ar4 * 1.9871;
        }
        $("#bargha_area_" + i).val(bargha_individual);

        totalArea1 = totalArea1 + ar1;
        totalArea2 = totalArea2 + ar2;
        totalArea3 = totalArea3 + ar3;
        totalArea4 = totalArea4 + ar4;

        if (!is_bajho && !is_charan_kharka) {
            area1 = area1 + ar1;
            area2 = area2 + ar2;
            area3 = area3 + ar3;
            area4 = area4 + ar4;
        }
    }
    if (param) {
        total_area = area1 * 6772.5752 + area2 * 338.6287 + area3 * 16.9314;
        total = totalArea1 * 6772.5752 + totalArea2 * 338.6287 + totalArea3 * 16.9314;
    } else {
        total_area = area1 * 508.7328 + area2 * 31.7958 + area3 * 7.9487 + area4 * 1.9871;
        total = totalArea1 * 508.7328 + totalArea2 * 31.7958 + totalArea3 * 7.9487 + totalArea4 * 1.9871;
    }
    $("#cultivable_area").val(total_area);
    $("#total_area").val(total);
}
