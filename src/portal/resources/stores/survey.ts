import { defineStore } from 'pinia'
import {Survey} from "../mixins/Survey";
import type {Choices} from "../interfaces/survey/Choice";
import {test_part_1} from "../assets/data/quetions";

export const useSurvey = defineStore('survey', {
    state: (): { survey: Survey,  } => ({
        survey: new Survey(),
    }),
    actions: {
        getSurvey() {
            return this.survey
        }
    },
})
