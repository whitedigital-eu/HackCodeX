const translates: any = {
    lv: {
        languages: 'Valodas',
        sport: 'Sport',
        math: 'Matemātik',
        physics: 'Fizika',
        geography: 'Ģeogrāfija',
        chemistry: 'Ķīmija',
        computers: 'Datorika',
        music: 'Mūzika',
        crafts: 'Mājturība',
        religion: 'Ŗeliģija',
        art: 'Māksla',
    }
}

export const t = (text: string): string => {
    const lang = 'lv';
    return translates[lang][text] ?? text;
}