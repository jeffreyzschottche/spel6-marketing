export const useStorageAsset = (relativePath: string) => {
  const config = useRuntimeConfig();
  const base =
    (config.public.storageBaseUrl as string | undefined) ??
    "http://localhost:8000";

  const normalizedBase = base.endsWith("/")
    ? base.slice(0, -1)
    : base;
  const normalizedPath = relativePath.startsWith("/")
    ? relativePath.slice(1)
    : relativePath;

  return `${normalizedBase}/${normalizedPath}`;
};
