import axios from 'axios';
import { Schema } from '@/avid/types/widget';

export function useAsyncWidget() {

    const loading = ref(false);

    const fetchData = async (id: string, params: any): Promise<Schema|null> => {
        try {
            const { data } = await axios.get(route('widgets.show', id), {
                params: {
                    ...(params ?? {}),
                }
            });

            return data as Schema;
        } catch (err: any) {
            return null;
        }
    }

    return {
        loading,
        fetchData,
    }
}