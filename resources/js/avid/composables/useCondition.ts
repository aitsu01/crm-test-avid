import { ConditionNode } from '@/avid/types/condition';

export function useCondition() {
    function evaluateCondition(data: any, condition: ConditionNode): boolean {
        // Caso 1: Il nodo è un GRUPPO di condizioni
        if (condition.type === 'group') {
            // Se il gruppo non ha figli, la valutazione dipende dall'operatore.
            // Un gruppo AND vuoto è sempre vero (non c'è nulla che possa fallire).
            // Un gruppo OR vuoto è sempre falso (non c'è nulla che possa essere vero).
            if (condition.children.length === 0) {
                return condition.operator === 'AND';
            }

            // Logica AND: tutti i figli devono restituire true.
            if (condition.operator === 'AND') {
                // every() si ferma al primo 'false' ed è perfetto per l'AND.
                return condition.children.every((child) => evaluateCondition(data, child));
            }

            // Logica OR: almeno un figlio deve restituire true.
            if (condition.operator === 'OR') {
                // some() si ferma al primo 'true' ed è perfetto per l'OR.
                return condition.children.some((child) => evaluateCondition(data, child));
            }
        }

        // Caso 2: Il nodo è una CONDIZIONE SINGOLA (caso base della ricorsione)
        if (condition.type === 'condition') {
            const dataValue = data[condition.field];
            const conditionValue = condition.value;

            // Esegui l'operazione di confronto
            switch (condition.operator) {
                case 'IS':
                    // Un campo è considerato NULL se è null, undefined o non esiste
                    return dataValue === null || dataValue === undefined;
                case 'IS NOT':
                    // Un campo è considerato NOT NULL se ha un valore diverso da null e undefined
                    return dataValue !== null && dataValue !== undefined;
                case '=':
                    // Usiamo '==' per una comparazione non stretta (es. 5 == "5" è true)
                    return dataValue == conditionValue;
                case '!=':
                case '<>':
                    return dataValue != conditionValue;
                case '>':
                    return dataValue > conditionValue;
                case '<':
                    return dataValue < conditionValue;
                case '>=':
                    return dataValue >= conditionValue;
                case '<=':
                    return dataValue <= conditionValue;
                case 'IN':
                case 'in':
                    return Array.isArray(conditionValue) && conditionValue.includes(dataValue);
                case 'NOT IN':
                case 'not in':
                    return Array.isArray(conditionValue) && !conditionValue.includes(dataValue);
                // Aggiungi altri operatori se necessario (es. LIKE, BETWEEN, etc.)
                default:
                    console.warn(`Operatore non supportato: "${condition.operator}"`);
                    return false;
            }
        }

        // Se il tipo di condizione non è né 'group' né 'condition', c'è un errore nella struttura.
        return false;
    }

    return {
        evaluateCondition,
    };
}
