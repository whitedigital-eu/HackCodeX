import type {Choice, ChoiceAttribute, Choices} from "../interfaces/survey/Choice";
import {test_part_1} from "../assets/data/quetions";

export enum SurveyState {
    PICTURE_QUIZ,
    SLIDER_QUIZ,
}
export class Survey {
    public state: SurveyState = SurveyState.PICTURE_QUIZ;
    public picture_index: number = 0;
    public attribute_summary: ChoiceAttribute = {
        pragmatic: 0,
        domestic: 0,
        traditional: 0,
        peaceful: 0,
        caring: 0,
        tolerant: 0,
        contemplative: 0,
        inquisitive: 0,
        experimental: 0,
        maximalist: 0,
        dominant: 0,
        ambitious: 0,
        tangible: 0,
        intangible: 0,
        relationships: 0,
        identity: 0,
        retention: 0,
        discovery: 0,
        others: 0,
        self: 0,
        safety: 0,
        confidence: 0,
        concord: 0,
        control: 0,
    };
    constructor() {

    }

    setState(state: SurveyState) {
        this.state = state;
    }

    addChoice(choice: Choice) {
        let $this = this;
        Object.keys(choice.attributes).forEach((item) => {
            // @ts-ignore
            $this.attribute_summary[item] += choice[item]

            // @ts-ignore
            console.log($this.attribute_summary[item], choice[item], item)
        });
        this.picture_index++;
    }

    getCurrentPictureQuizQuestion(): Choices {
        return test_part_1[this.picture_index];
    }
}