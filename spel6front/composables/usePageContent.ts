import { computed } from "vue";
import { useApi } from "~/composables/useApi";

export interface ContentField {
  id: number;
  page: string;
  field: string;
  type: string;
  value: string | null;
}

export interface PageContentResponse {
  page: string;
  fields: Record<string, ContentField>;
  items: ContentField[];
}

export async function usePageContent(pageName: string) {
  const api = useApi();
  const asyncData = await useAsyncData(`content-${pageName}`, () =>
    api.get<PageContentResponse>(`/pages/${pageName}/content`)
  );

  const page = computed(() => asyncData.data.value?.fields ?? {});

  return {
    page,
    ...asyncData,
  };
}
