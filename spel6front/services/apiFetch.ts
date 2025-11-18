// ~/services/api.ts
import { Capacitor } from "@capacitor/core";
import { ApiError } from "./ApiError";
import { useRuntimeConfig } from "#imports";

/** Bepaalt aan de hand van platform & env de juiste basis-URL */
const getApiBaseUrl = () => {
  const config = useRuntimeConfig();

  // // Android-emulator: 10.0.2.2 verwijst naar je host-machine
  // if (Capacitor.getPlatform() === "android") {
  //   return "http://10.0.2.2:8000/api";
  // }

  // Web / iOS / desktop: gebruik waarde uit nuxt.config → runtimeConfig.public.apiBaseUrl
  return config.public.apiBaseUrl;
};

/**
 * Eenvoudige fetch-wrapper.
 * - Voegt automatisch het base-URL-prefix toe
 * - Gooit een Error bij non-2xx responses
 * - Geeft JSON terug ( of `null` bij 204 )
 */
export async function apiFetch<T = any>(
  endpoint: string,
  options: RequestInit = {}
): Promise<T> {
  const res = await fetch(`${getApiBaseUrl()}${endpoint}`, options);

  if (res.status === 204) return null as unknown as T;
  if (!res.ok) {
    let data: any = null;
    try {
      data = await res.json();
    } catch {}
    throw new ApiError(res.status, data);
  }
  return res.json() as Promise<T>;
}
