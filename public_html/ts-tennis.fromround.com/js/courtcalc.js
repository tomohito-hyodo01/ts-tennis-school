function calculatePrice() {
    // 各要素の値を取得
    const courtPrice = parseFloat(document.getElementById('court_price').value) || 0;
    const memberNum = parseFloat(document.getElementById('member_num').value) || 0;
    const nonMemberNum = parseFloat(document.getElementById('non_member_num').value) || 0;

    // 計算を行い、結果をmember_price要素に出力
    const total_num = memberNum + nonMemberNum;
    const member_price = Math.floor((courtPrice / total_num) / 100) * 100 - 100;
    const member_total_price = member_price * memberNum;
    const non_member_price = Math.ceil(((courtPrice - member_total_price) / nonMemberNum) / 100) * 100 + 100;
    // 差額を計算
    const surplus = (non_member_price * nonMemberNum) + member_total_price - courtPrice;
    
    document.getElementById('member_price').textContent = member_price.toFixed(0);
    document.getElementById('non_member_price').textContent = non_member_price.toFixed(0);
    document.getElementById('surplus').textContent = surplus.toFixed(0);
}

// court_price, member_num, non_member_num要素の値が変更されたときにイベントリスナーを設定
document.getElementById('court_price').addEventListener('input', calculatePrice);
document.getElementById('member_num').addEventListener('input', calculatePrice);
document.getElementById('non_member_num').addEventListener('input', calculatePrice);

function calculatePrice_balance() {
    // 各要素の値を取得
    const courtPrice = parseFloat(document.getElementById('court_price').value) || 0;
    const memberNum = parseFloat(document.getElementById('member_num').value) || 0;
    const nonMemberNum = parseFloat(document.getElementById('non_member_num').value) || 0;

    const memberPrice = parseFloat(document.getElementById('member_price').textContent) || 0;
    const nonMemberPrice = parseFloat(document.getElementById('non_member_price').textContent) || 0;
    // 会員価格を増加
    const recalc_member_price = memberPrice + 100;
    const plus_member_price = 100 * memberNum
    // 会員価格合計を計算
    const recalc_member_total_price = recalc_member_price * memberNum;
    // 非会員価格を減額
    const recalc_non_member_price = Math.ceil((nonMemberPrice - (plus_member_price / nonMemberNum)) / 100 ) * 100;
    // 差額再計算
    const recalc_surplus = (recalc_non_member_price * nonMemberNum) + recalc_member_total_price - courtPrice;

    document.getElementById('member_price').textContent = recalc_member_price.toFixed(0);
    document.getElementById('non_member_price').textContent = recalc_non_member_price.toFixed(0);
    document.getElementById('surplus').textContent = recalc_surplus.toFixed(0);
}

document.getElementById('recalculate').addEventListener('click', calculatePrice_balance);
document.getElementById('reset').addEventListener('click', calculatePrice);

/* Vueテスト後開発
Vue.createApp({
    data: function () {
        return {
            court_price: '',
            member_num: '',
            non_member_num: '',
            member_price: '1000',
            non_member_price: ''
        };
    },
}).mount("#app");
*/
