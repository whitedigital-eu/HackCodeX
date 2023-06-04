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

        pragmatic: 'Pragmatiskais',
        domestic: 'Ģimeniskais',
        traditional: 'Tradicionālais',
        peaceful: 'Miermīlīgais',
        caring: 'Gādīgais',
        tolerant: 'Iecietīgais',
        contemplative: 'Vērojošais',
        inquisitive: 'Zinātkārais',
        experimental: 'Izzinošais',
        maximalist: 'Maksimālists',
        dominant: 'Vadošais',
        ambitious: 'Ambiciozais',
        tangible: 'Matereālais',
        intangible: 'Nematereālais',
        relationships: 'Attiecības',
        identity: 'Identitāte',
        retention: 'Saglabāšana',
        discovery: 'Atklājumi',
        others: 'Citi',
        self: 'Pats',
        safety: 'Drošība',
        confidence: 'Pārliecība',
        concord: 'Harmonija',
        control: 'Kontrole',
    }
}

export const t = (text: string): string => {
    const lang = 'lv';
    return translates[lang][text] ?? text;
}