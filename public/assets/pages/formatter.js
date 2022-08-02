function rumus(value) {
    let result = null;

    switch (value) {
        case 'tambah':
            result = 'Penjumlahan';
            break;

        case 'kurang':
            result = 'Pengurangan';
            break;

        case 'kali':
            result = 'Perkalian';
            break;

        case 'bagi':
            result = 'Pembagian';
            break;

        case 'percent':
            result = 'Persentase';
            break;

        case 'samadengan':
            result = 'Sama Dengan';
            break;
    
        default:
            result = '';
            break;
    }

    return result;
}

function ucfirst (params) {
    const str2 = params.charAt(0).toUpperCase() + params.slice(1);
    
    return str2;
}