export class ApiError extends Error {
  status: number;
  data: any;

  constructor(status: number, data?: any) {
    super("API request failed");
    this.name = "ApiError";
    this.status = status;
    this.data = data ?? null;
  }
}
