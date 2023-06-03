export interface Choices {
    choices: Choice[]
}

export interface Choice {
    image: string,
    attributes: ChoiceAttribute
}

export interface ChoiceAttribute {
    pragmatic?: number,
    domestic?: number,
    traditional?: number,
    peaceful?: number,
    caring?: number,
    tolerant?: number,
    contemplative?: number,
    inquisitive?: number,
    experimental?: number,
    maximalist?: number,
    dominant?: number,
    ambitious?: number,
    tangible?: number,
    intangible?: number,
    relationships?: number,
    identity?: number,
    retention?: number,
    discovery?: number,
    others?: number,
    self?: number,
    safety?: number,
    confidence?: number,
    concord?: number,
    control?: number,
}